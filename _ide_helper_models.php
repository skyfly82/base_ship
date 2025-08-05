<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $api_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Carrier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Carrier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Carrier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Carrier whereApiCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Carrier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Carrier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Carrier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Carrier whereUpdatedAt($value)
 */
	class Carrier extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string $password
 * @property int $active
 * @property string|null $company_name
 * @property string|null $tax_id
 * @property string $customer_type
 * @property string $country
 * @property string $city
 * @property string $postal_code
 * @property string $street
 * @property string $building_number
 * @property string|null $apartment_number
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereApartmentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereBuildingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCustomerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereUpdatedAt($value)
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $customer_id
 * @property int|null $settlement_id
 * @property string $invoice_number
 * @property string $issue_date
 * @property string|null $billing_period_start
 * @property string|null $billing_period_end
 * @property string $amount_net
 * @property string $amount_vat
 * @property string $amount_gross
 * @property string $currency
 * @property string|null $details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\Settlement|null $settlement
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereAmountGross($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereAmountNet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereAmountVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereBillingPeriodEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereBillingPeriodStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereSettlementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereUpdatedAt($value)
 */
	class Invoice extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $customer_id
 * @property string $amount_net
 * @property string $amount_vat
 * @property string $amount_gross
 * @property string $currency
 * @property int $payment_method_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\PaymentMethod $paymentMethod
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereAmountGross($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereAmountNet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereAmountVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereUpdatedAt($value)
 */
	class PaymentMethod extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $carrier_id
 * @property string $price
 * @property string $service_type
 * @property string $currency
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing whereCarrierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing whereServiceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing whereUpdatedAt($value)
 */
	class Pricing extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $customer_id
 * @property string $billing_cycle
 * @property string|null $next_billing_date
 * @property int|null $billing_day1
 * @property int|null $billing_day2
 * @property int|null $monthly_billing_day
 * @property string|null $weekly_billing_day
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settlement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settlement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settlement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settlement whereBillingCycle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settlement whereBillingDay1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settlement whereBillingDay2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settlement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settlement whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settlement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settlement whereMonthlyBillingDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settlement whereNextBillingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settlement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Settlement whereWeeklyBillingDay($value)
 */
	class Settlement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $customer_id
 * @property int $carrier_id
 * @property int|null $order_id
 * @property string|null $tracking_number
 * @property string $status
 * @property string|null $length_cm
 * @property string|null $width_cm
 * @property string|null $height_cm
 * @property string|null $weight_kg
 * @property string|null $billing_weight_kg
 * @property string|null $details
 * @property int|null $system_user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereBillingWeightKg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereCarrierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereHeightCm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereLengthCm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereSystemUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereTrackingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereWeightKg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment whereWidthCm($value)
 */
	class Shipment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property int $active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereUpdatedAt($value)
 */
	class SystemUser extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

