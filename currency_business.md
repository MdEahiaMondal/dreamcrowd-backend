হ্যাঁ, ক্লায়েন্ট **Currency** নিয়ে একদম ক্লিয়ারলি বলেছে। তার চাওয়া এই রকম:

### ক্লায়েন্ট যা চায় (১০০% সঠিক)

1. **ওয়েবসাইটে সব জায়গায় শুধু USD ($) দেখাবে**  
   → Buyer যখন পেমেন্ট করবে, তখন শুধু US Dollar-এই দেখবে এবং পে করবে।  
   → Seller-এর ড্যাশবোর্ডেও সব হিসাব USD-এই দেখাবে।

2. **কোম্পানি UK-তে থাকলেও পেমেন্ট USD-এই নেবে**  
   → ক্লায়েন্ট বলেছে: “We are a UK company, but we will take payments in USD only.”

3. **Stripe যখন টাকা কোম্পানির অ্যাকাউন্টে পাঠাবে, তখন Stripe নিজে থেকে USD → GBP-তে কনভার্ট করে দেবে**  
   → ক্লায়েন্ট জানতে চেয়েছে: “Stripe কি নিজে থেকে USD কে GBP-তে কনভার্ট করে দেবে নাকি আমাদের ম্যানুয়ালি করতে হবে?”  
   → সে চায় এটা যেন **অটোমেটিক** হয় (Stripe-এর ডিফল্ট সেটিং-এই হয়ে যায় যদি payout currency GBP রাখি)।

4. **Seller-রা যখন টাকা তুলবে**
    - যারা PayPal/Stripe ব্যবহার করবে → তাদের নিজের দেশের কারেন্সিতে চলে যাবে (Stripe/PayPal নিজে কনভার্ট করে দেবে)
    - বাংলাদেশ/পাকিস্তানের জন্য লোকাল মেথড (bKash/Nagad) থাকলে → সেখানে USD → BDT/PKR কনভার্ট করে দিতে হবে (হয় ম্যানুয়ালি নয়তো কোনো API দিয়ে)

### সারাংশে ক্লায়েন্টের এক লাইনের কথা:
“Website-এ সবাই শুধু USD দেখবে আর পে করবে।  
কোম্পানি UK-তে থাকলেও আমরা USD-এই পেমেন্ট নেব।  
Stripe নিজে থেকে USD → GBP করে আমার ব্যাংকে পাঠিয়ে দেবে – এটাই চাই।”

তাই আমাদের করতে হবে:
- ফ্রন্টএন্ডে সব জায়গায় শুধু `$` আর USD
- Stripe payout currency → GBP সেট করতে হবে (তাহলে Stripe অটো কনভার্ট করবে)
- Seller payout এর সময় তাদের লোকাল কারেন্সি দেখানোর দরকার নেই – তারা USD-এই দেখবে, বাকি কনভার্শন Stripe/PayPal করবে।

সাথে আমার ক্লাইন্ট এটাও বলছে যে এডমিন প্যানেল থেকে সেলার প্যানেল থেকে অথবা ইউজার প্যানেল থেকে এবং পাবলিক প্যানেল পাবলিক যে ল্যান্ডিং পেজ আছে সেখান থেকে ইউজার চাইলে তাদের কারেন্সি কারেন্সি চেঞ্জ করে সবকিছু তাদের নিজেদের কারেন্সিতে দেখতে পারে এখন বর্তমানে আমাদের ডাটাবেজে ইউএসডিতে আছে মাত্র দুইটা কারেন্সি এখন সাপোর্ট করবে একটা হচ্ছে ইউএসডি মানে ডলার এবং আরেকটা GBP




<?php

namespace App\Jobs;

use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class UpdateCurrencyRate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $apiKey = config('services.currencies.api_key');
        $api_url = config('services.currencies.api_url');

        $currencies = Currency::query()->get();
        $default_currency = $currencies?->where('is_default', 1)?->first();
        $all_currencies = $currencies->pluck('code')->unique()->values()->toArray();
        $all_currencies = implode(',', $all_currencies);

        if ($all_currencies && $apiKey) {
            $params = [
                'apikey' => $apiKey,
                'currencies' => $all_currencies,
                'base_currency' => $default_currency?->code,
            ];
            $response = Http::get($api_url, $params);
            if ($response->successful()) {
                $all = $response->json()['data'] ?? [];
                foreach ($all as $currency) {
                    $exist_currency = Currency::query()->where('code', $currency['code'])->first();
                    if ($exist_currency) {
                        $exit_currency_rate = ExchangeRate::query()
                            ->where([
                                'to_currency_id' => $exist_currency->id,
                            ])->first();
                        if (!$exit_currency_rate) {
                            $exit_currency_rate = ExchangeRate::create([
                                'from_currency_id' => $default_currency->id,
                                'to_currency_id' => $exist_currency->id,
                                'rate' => $currency['value'],
                            ]);
                        }
                        $exit_currency_rate->from_currency_id = $default_currency->id;
                        $exit_currency_rate->rate = $currency['value'];
                        $exit_currency_rate->active = $exist_currency->active;
                        $exit_currency_rate->save();
                    }
                }
                dispatch(new UpdateCurrencyRate());
            }
        }
    }
}


CURRENCY_API_KEY=cur_live_huM4IbE5EgMP2i7FvjyjZf3rhjoI1Ay79WD6V2SE
CURRENCY_API_URL=https://api.currencyapi.com/v3/latest


