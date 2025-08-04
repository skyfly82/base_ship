📚 Dokumentacja Techniczna: Courier Broker Microservice
1. Podstawowe dane
Nazwa: Courier Broker Microservice (base_ship)

Technologie:

PHP: 8.3 (Docker, oficjalny obraz laravelsail/php83-composer)

Laravel: 11.x (czyste API, bez Blade/Frontu)

Baza danych: MySQL 8.4 (Docker), Eloquent ORM

Kolejka: Laravel Queue (sync/dev, można wyjść na Redis/Beanstalk)

Inne: league/csv (do importu/eksportu CSV), Docker Compose, phpMyAdmin

Kontenery: nginx, php, mysql, phpmyadmin

Repozytorium: np. ~/Projekty/BASE_SHIP_admin_panel

Schemat wdrożenia: local docker, produkcja – osobny projekt

Cel: mikroserwis brokerski obsługujący przesyłki, zamówienia, faktury, integracje, webhooks.

2. Stack/Architektura
Docker Compose:

nginx (reverse proxy) — port 8080

app (php8.3 + composer + artisan) — bezpośrednio na porcie 9000 (wew. dla nginx)

mysql (8.4) — port 3307

phpmyadmin — port 8081

Schemat:

less
Kopiuj
Edytuj
[EXTERNAL SYSTEM]---\
[COURIER API]-------+--(nginx:8080)---(php:9000: Laravel 11, API)
[INTERNAL SYSTEM]---/
                    |
                 [MySQL 8.4]
                    |
              [phpMyAdmin:8081]
3. Główne katalogi i pliki
/app/Http/Controllers/Api/ShipmentApiController.php

/app/Http/Controllers/Api/OrderApiController.php

/app/Http/Controllers/Api/InvoiceApiController.php

/app/Http/Controllers/Api/WebhookCarrierController.php

/app/Http/Controllers/Api/WebhookInternalController.php

/app/Models/Shipment.php

/app/Models/Order.php

/app/Models/Invoice.php

/app/Models/SystemUser.php

/app/Jobs/ProcessInternalWebhookJob.php

/database/seeders/DatabaseSeeder.php

/database/seeders/SystemUserSeeder.php

/routes/api.php

/config/auth.php

/app/Http/Middleware/AuthSystemUser.php

/docker-compose.yml

/public/index.php

/storage/logs/laravel.log

/composer.json

Swagger/OpenAPI: /docs/swagger.json (do wygenerowania, niżej przykład!)

4. Modele/Eloquent
Shipment
php
Kopiuj
Edytuj
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'customer_id', 'carrier_id', 'tracking_number', 'status',
        'length_cm', 'width_cm', 'height_cm',
        'weight_kg', 'billing_weight_kg', 'details',
        'order_id', 'system_user_id',
    ];
}
SystemUser
php
Kopiuj
Edytuj
<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SystemUser extends Authenticatable
{
    protected $table = 'system_users';
    protected $fillable = ['name', 'email', 'password', 'api_token'];
    protected $hidden = ['password', 'api_token'];
}
(analogicznie Order, Invoice...)
5. Struktura bazy i migracje
Przykład – system_users:

php
Kopiuj
Edytuj
// database/migrations/xxxx_xx_xx_create_system_users_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('system_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('api_token', 80)->unique()->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('system_users');
    }
};
Analogicznie Shipment, Order, Invoice...

6. Seedery
Seeder użytkownika systemowego
php
Kopiuj
Edytuj
// database/seeders/SystemUserSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\SystemUser;

class SystemUserSeeder extends Seeder
{
    public function run()
    {
        SystemUser::create([
            'name' => 'Internal',
            'email' => 'internal@example.com',
            'password' => Hash::make('supersecurepassword'),
        ]);
    }
}
Włączenie w głównym seederze:

php
Kopiuj
Edytuj
// database/seeders/DatabaseSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            SystemUserSeeder::class,
            CustomerAndSettlementSeeder::class,
            ShipmentAndOrderSeeder::class,
        ]);
    }
}
7. Middleware + Auth
Middleware po loginie/haśle
/app/Http/Middleware/AuthSystemUser.php

php
Kopiuj
Edytuj
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthSystemUser
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('system_users')->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
Rejestracja middleware w /app/Http/Kernel.php (w Laravel 11: middleware w kontrolerach lub bootstrapping – patrz docs)
Przykład użycia w kontrolerze:

php
Kopiuj
Edytuj
public function __construct()
{
    $this->middleware('auth.basic:system_users')->only(['receive']);
}
8. Plik konfiguracyjny auth
/config/auth.php – przykład:

php
Kopiuj
Edytuj
<?php

return [
    // ...
    'guards' => [
        // ...
        'system_users' => [
            'driver' => 'session',
            'provider' => 'system_users',
        ],
    ],
    'providers' => [
        // ...
        'system_users' => [
            'driver' => 'eloquent',
            'model' => App\Models\SystemUser::class,
        ],
    ],
];
9. API Routing
routes/api.php – pełny, rozbudowany:

php
Kopiuj
Edytuj
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShipmentApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\InvoiceApiController;
use App\Http\Controllers\Api\WebhookCarrierController;
use App\Http\Controllers\Api\WebhookInternalController;

// Test endpoint
Route::get('/ping', fn() => response()->json(['pong' => true]));

// Shipments
Route::apiResource('shipments', ShipmentApiController::class);
Route::patch('shipments/{shipment}/cancel', [ShipmentApiController::class, 'cancel']);
Route::get('shipments/{shipment}/label', [ShipmentApiController::class, 'label']);
Route::get('shipments/export', [ShipmentApiController::class, 'exportCsv']);
Route::post('shipments/import', [ShipmentApiController::class, 'importCsv']);

// Orders
Route::apiResource('orders', OrderApiController::class);

// Invoices
Route::apiResource('invoices', InvoiceApiController::class);

// Webhooks (autoryzacja po system_users!)
Route::post('webhook/carrier/{carrier}', [WebhookCarrierController::class, 'receive']);
Route::post('webhook/internal', [WebhookInternalController::class, 'receive']);
10. Przykłady kontrolerów
WebhookInternalController
php
Kopiuj
Edytuj
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessInternalWebhookJob;

class WebhookInternalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.basic:system_users');
    }

    public function receive(Request $request)
    {
        $systemUser = Auth::user();

        Log::info("Internal webhook received", [
            'user_id' => $systemUser?->id,
            'user_email' => $systemUser?->email,
            'ip' => $request->ip(),
            'payload' => $request->all(),
        ]);

        $validated = $request->validate([
            'event_type' => 'required|string|max:255',
            'payload'    => 'required|array',
        ]);

        ProcessInternalWebhookJob::dispatch(
            $validated['event_type'],
            $validated['payload'],
            $systemUser?->id
        );

        return response()->json([
            'success' => true,
            'message' => 'Webhook (internal) received and dispatched',
        ]);
    }
}
Analogicznie inne kontrolery.

11. Przykład joba (asynchroniczne zadanie)
/app/Jobs/ProcessInternalWebhookJob.php

php
Kopiuj
Edytuj
<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessInternalWebhookJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $eventType;
    protected $payload;
    protected $userId;

    public function __construct($eventType, $payload, $userId = null)
    {
        $this->eventType = $eventType;
        $this->payload = $payload;
        $this->userId = $userId;
    }

    public function handle()
    {
        Log::info("Processing internal webhook job", [
            'event_type' => $this->eventType,
            'payload'    => $this->payload,
            'user_id'    => $this->userId,
        ]);
        // TODO: Obsługa zdarzeń na podstawie event_type
    }
}
12. Import/Export CSV
Instalacja:
composer require league/csv

ShipmentApiController – fragment:

php
Kopiuj
Edytuj
public function exportCsv()
{
    $shipments = Shipment::all();
    $csv = \League\Csv\Writer::createFromString('');
    $csv->insertOne(['id', 'tracking_number', ...]);
    foreach ($shipments as $shipment) {
        $csv->insertOne([$shipment->id, $shipment->tracking_number, ...]);
    }
    return response($csv->toString(), 200)->header('Content-Type', 'text/csv');
}

public function importCsv(Request $request)
{
    $csv = \League\Csv\Reader::createFromString($request->file('csv')->get());
    $csv->setHeaderOffset(0);
    foreach ($csv as $record) {
        Shipment::updateOrCreate(['tracking_number' => $record['tracking_number']], $record);
    }
    return response()->json(['success' => true]);
}
13. Przykłady curl do endpointów
Ping:

sh
Kopiuj
Edytuj
curl http://localhost:8080/api/ping
Webhook internal (auth):

sh
Kopiuj
Edytuj
curl -u Internal:supersecurepassword -X POST http://localhost:8080/api/webhook/internal \
  -H "Content-Type: application/json" \
  -d '{"event_type":"test","payload":{"foo":1}}'
Lista przesyłek:

sh
Kopiuj
Edytuj
curl http://localhost:8080/api/shipments
Import CSV:

sh
Kopiuj
Edytuj
curl -X POST -F 'csv=@/path/to/shipments.csv' http://localhost:8080/api/shipments/import
14. Swagger/OpenAPI (przykład pliku)
json
Kopiuj
Edytuj
{
  "openapi": "3.0.0",
  "info": {
    "title": "Courier Broker Microservice API",
    "version": "1.0.0"
  },
  "servers": [{"url": "http://localhost:8080/api"}],
  "paths": {
    "/ping": {
      "get": {
        "summary": "Ping check",
        "responses": { "200": { "description": "OK" } }
      }
    },
    "/shipments": {
      "get": {
        "summary": "List shipments",
        "responses": { "200": { "description": "List" } }
      }
    },
    "/webhook/internal": {
      "post": {
        "summary": "Przyjmij webhook od systemu wewnętrznego",
        "requestBody": {
          "content": {
            "application/json": {
              "schema": { "$ref": "#/components/schemas/WebhookRequest" }
            }
          }
        },
        "responses": {
          "200": { "description": "Webhook accepted" }
        }
      }
    }
  },
  "components": {
    "schemas": {
      "WebhookRequest": {
        "type": "object",
        "properties": {
          "event_type": { "type": "string" },
          "payload": { "type": "object" }
        },
        "required": ["event_type", "payload"]
      }
    }
  }
}
Plik można generować w /docs/swagger.json i edytować pod rozwój.

15. ClickUp – gotowiec do tasków/automatyzacji
Folder: Courier Microservice

Listy:

Backend (Endpoints + Kontrolery)

Integracje (Webhooki, zewnętrzne API)

DevOps (Docker, deploy)

QA/Testy (curl, Postman, e2e)

Architektura & Dokumentacja (diagramy, Swagger, markdown)

Szablon taska:

Typ: Endpoint/Feature/Job

Opis: np. "Webhook Internal – autoryzacja Basic Auth na bazie system_users, logowanie requestów, dispatch na queue, walidacja JSON, status 200/401."

Checklist: Test curl / Test błędu / Log w storage/logs / Pokrycie w Swagger

16. Monitoring, logi, best practices
Logi: Wszystko do /storage/logs/laravel.log

Odczytywanie logów:

sh
Kopiuj
Edytuj
tail -f storage/logs/laravel.log
Dostęp do API tylko przez nginx i po VPN (w produkcji – blokada firewall/IP whitelist).

Każdy endpoint z walidacją, logowaniem, autoryzacją (jeśli dotyczy).

Joby obsługiwane asynchronicznie przez php artisan queue:work.

Import/eksport CSV tylko po autoryzacji, logowane.

17. ToDo/rozwojowe
Kolejne webhooki (np. statusy kurierów, automatyzacje)

Rozbudowa userów/system_users (role, tokeny)

Więcej testów (phpunit, Postman)

Generacja pełnego Swaggera (np. za pomocą Laravel OpenAPI Generator)

Onboarding/CI/CD (przykład gotowych pipeline do repo)

Automatyczne generowanie diagramów przy deployu

ClickUp – pełne repo tasków do przerzucenia z tego dokumentu