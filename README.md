# BASE_SHIP – Broker usług kurierskich

Nowoczesny system do zarządzania przesyłkami, zamówieniami, fakturami oraz rozliczeniami dla klientów B2C i B2B.

---

## Funkcjonalności

- Dashboard klienta (ostatnie przesyłki, zamówienia, faktury)
- Moduł faktur i harmonogram rozliczeń (automatyczne generowanie wg cyklu klienta)
- Podgląd przesyłek, zamówień, faktur (Blade)
- Seedery – testowi klienci, przewoźnicy, zamówienia, przesyłki, płatności
- Pełny model danych: Customers, Orders, Shipments, Invoices, Pricings, Settlements, Carriers, SystemUsers, PaymentMethods
- Laravel 11 + Docker Compose + phpMyAdmin

---

## Szybki start (development)

### 1. Klonowanie repozytorium

```bash
git clone https://github.com/skyfly82/base_ship.git
cd base_ship
2. Ustaw środowisko
Skopiuj plik .env.example do .env

Upewnij się, że dane do bazy (DB_HOST=db itd.) pasują do docker-compose.yml

W razie potrzeby zmień klucz aplikacji:

bash
Kopiuj
Edytuj
docker compose exec app php artisan key:generate
3. Odpal Dockera
bash
Kopiuj
Edytuj
docker compose up -d --build
Laravel: http://localhost:8080

phpMyAdmin: http://localhost:8081 (login: base_ship/secret lub root/root)

4. Wykonaj migracje i seedery
bash
Kopiuj
Edytuj
docker compose exec app php artisan migrate:fresh --seed
Struktura projektu
app/Models/ – modele (Customer, Order, Shipment, Invoice, ...)

database/migrations/ – migracje bazy danych (odpowiednia kolejność!)

database/seeders/ – seedery przykładowych danych (klienci, zamówienia, przesyłki, płatności)

app/Http/Controllers/ – kontrolery dashboardu, faktur, przesyłek

resources/views/ – widoki blade (dashboard, faktury, przesyłki)

routes/web.php – trasy aplikacji (dashboard, faktury, przesyłki)

docker-compose.yml, docker/php/Dockerfile – środowisko uruchomieniowe

Domyślne loginy/testowe dane
Klient B2C:

Email: jan.kowalski@example.com

Hasło: password

Klient B2B:

Email: kontakt@firmaabc.pl

Hasło: password

Komendy developerskie
Wymuś ponowną instalację bazy + seedowanie:

bash
Kopiuj
Edytuj
docker compose exec app php artisan migrate:fresh --seed
Generowanie faktur wg harmonogramu:

bash
Kopiuj
Edytuj
docker compose exec app php artisan invoices:generate
ToDo (kolejne kroki)
API i webhooki do integracji z kurierami

Dashboard systemowy/operatora

Moduł wyceny przesyłek (cenniki dynamiczne)

Rozwój panelu klienta (nadawanie przesyłek, tracking)

Autor:
skyfly82
2025
