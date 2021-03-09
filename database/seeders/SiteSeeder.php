<?php

namespace Database\Seeders;

use App\Components\Site\Domain\Enum\LocaleEnum;
use App\Components\Site\Infrastructure\Entity\Continent;
use App\Components\Site\Infrastructure\Entity\Country;
use App\Components\Site\Infrastructure\Entity\Currency;
use App\Components\Site\Infrastructure\Entity\Language;
use App\System\Messaging\Integration\Service\JsonSerializer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;

class SiteSeeder extends Seeder
{
    /**
     * @param JsonSerializer $serializer
     */
    public function run(JsonSerializer $serializer): void
    {
        foreach (LocaleEnum::values() as $code) {
            $this->seedLanguage($code->getValue());
        }

        $source = database_path('/dump/continents.json');
        foreach ($serializer->decode(file_get_contents($source)) as $code => $names) {
            $this->seedContinent($code, $names);
        }

        $source = database_path('/dump/countries.json');
        foreach ($serializer->decode(file_get_contents($source)) as $code => $data) {
            if ('AQ' === $code) {
                continue;
            }

            $this->seedCountry($code, $data);
        }
    }

    /**
     * @param string $code
     */
    private function seedLanguage(string $code): void
    {
        Language::query()->updateOrCreate(['code' => $code], [
            'native_name' => Str::ucfirst(Languages::getName($code, $locale = $code)),
        ]);
    }

    /**
     * @param string   $code
     * @param string[] $names
     */
    private function seedContinent(string $code, array $names): void
    {
        Continent::query()->updateOrCreate(['code' => $code], [
            LocaleEnum::EN()->getValue() => ['name' => $names[LocaleEnum::EN()->getValue()]],
            LocaleEnum::PL()->getValue() => ['name' => $names[LocaleEnum::PL()->getValue()]],
        ]);
    }

    /**
     * @param string $code
     */
    private function seedCurrency(string $code): void
    {
        Currency::query()->updateOrCreate(['code' => $code]);
    }

    /**
     * @param string $code
     * @param array  $data
     */
    private function seedCountry(string $code, array $data): void
    {
        /** @var Country $entity */
        $entity = Country::query()->updateOrCreate(['code' => $code], [
            'continent_code' => $data['continent'],
            'native_name' => $data['native'],
            LocaleEnum::EN()->getValue() => ['name' => $data['name']],
            LocaleEnum::PL()->getValue() => ['name' => $this->translateCountryToPolish($code, $data['name'])],
        ]);

        foreach (explode(',', $data['phone']) as $prefix) {
            if (false === $entity->phones()->where(['prefix' => $prefix])->exists()) {
                $entity->phones()->create(['prefix' => $prefix]);
            }
        }

        foreach ($data['languages'] as $language) {
            $this->seedLanguage($language);
            if (false === $entity->languages()->where(['language_code' => $language])->exists()) {
                $entity->languages()->create(['language_code' => $language]);
            }
        }

        foreach (explode(',', $data['currency']) as $currency) {
            $this->seedCurrency($currency);
            if (false === $entity->currencies()->where(['currency_code' => $currency])->exists()) {
                $entity->currencies()->create(['currency_code' => $currency]);
            }
        }
    }

    /**
     * @param string $code
     * @param string $default
     *
     * @return string
     */
    private function translateCountryToPolish(string $code, string $default): string
    {
        try {
            return Countries::getName($code, LocaleEnum::PL()->getValue());
        } catch (\Exception $exception) {
            return $default;
        }
    }
}
