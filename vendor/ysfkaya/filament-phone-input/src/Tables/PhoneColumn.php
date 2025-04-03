<?php

namespace Ysfkaya\FilamentPhoneInput\Tables;

use Closure;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use libphonenumber\PhoneNumberFormat;
use Propaganistas\LaravelPhone\Exceptions\NumberParseException;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;

class PhoneColumn extends TextColumn
{
    protected string | Closure | null $countryColumn = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->displayFormat(PhoneInputNumberType::NATIONAL);
    }

    public function countryColumn(string | Closure $column): static
    {
        $this->countryColumn = $column;

        return $this;
    }

    public function getCountryColumn()
    {
        return $this->evaluate($this->countryColumn);
    }

    public function displayFormat(PhoneInputNumberType $format)
    {
        return $this->formatStateUsing(function (PhoneColumn $column, $state) use ($format) {
            try {
                $countryColumn = $this->getCountryColumn();

                $country = [];

                if ($countryColumn) {
                    $country = $column->getCountryState();
                }

                $format = $format->toLibPhoneNumberFormat();

                $formatted = phone(
                    number: $state,
                    country: $country,
                    format: $format
                );

                if ($format === (enum_exists(PhoneNumberFormat::class) ? PhoneNumberFormat::RFC3966->value : PhoneNumberFormat::RFC3966)) {
                    $national = phone(
                        number: $state,
                        country: $country,
                        format: PhoneNumberFormat::NATIONAL
                    );

                    $html = <<<HTML
                        <a href="$formatted" dir="ltr">
                            $national
                        </a>
                    HTML;

                } else {
                    $html = <<<HTML
                        <span dir="ltr">
                            $formatted
                        </span>
                    HTML;
                }

                return new HtmlString($html);
            } catch (NumberParseException $e) {
                return $state;
            }
        })->when($format === PhoneInputNumberType::RFC3966, fn (PhoneColumn $column) => $column->disabledClick());
    }

    public function getCountryState()
    {
        if (! $this->getRecord()) {
            return null;
        }

        $column = $this->getCountryColumn();

        if (! $column) {
            return null;
        }

        $record = $this->getRecord();

        $state = data_get($record, $column);

        if ($state !== null) {
            return $state;
        }

        if (! $this->hasRelationship($record)) {
            return null;
        }

        $relationship = $this->getRelationship($record);

        if (! $relationship) {
            return null;
        }

        $relationshipAttribute = $this->getRelationshipAttribute($column);

        $state = collect($this->getRelationshipResults($record))
            ->filter(fn (Model $record): bool => array_key_exists($relationshipAttribute, $record->attributesToArray()))
            ->pluck($relationshipAttribute)
            ->filter(fn ($state): bool => filled($state))
            ->when($this->isDistinctList(), fn (Collection $state) => $state->unique())
            ->values();

        if (! $state->count()) {
            return null;
        }

        return $state->all();
    }
}
