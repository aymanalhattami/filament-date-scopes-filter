<?php

namespace AymanAlhattami\FilamentDateScopesFilter;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Illuminate\Database\Eloquent\Builder;
use LaracraftTech\LaravelDateScopes\DateRange;

class DateScopeFilter extends Filter
{
    private function scopes(): array
    {

        return [
            __('filament-date-scopes-filter::date-scope.Seconds.label') => [
                'ofJustNow' => __('filament-date-scopes-filter::date-scope.Seconds.ofJustNow'),
                'ofLastSecond' => __('filament-date-scopes-filter::date-scope.Seconds.ofLastSecond'),
                'ofLast15Seconds' => __('filament-date-scopes-filter::date-scope.Seconds.ofLast15Seconds'),
                'ofLast30Seconds' => __('filament-date-scopes-filter::date-scope.Seconds.ofLast30Seconds'),
                'ofLast45Seconds' => __('filament-date-scopes-filter::date-scope.Seconds.ofLast45Seconds'),
                'ofLast60Seconds' => __('filament-date-scopes-filter::date-scope.Seconds.ofLast60Seconds'),
                'ofLastSeconds' => __('filament-date-scopes-filter::date-scope.Seconds.ofLastSeconds'),
            ],
            __('filament-date-scopes-filter::date-scope.Minutes.label') => [
                'ofLastMinute' => __('filament-date-scopes-filter::date-scope.Minutes.ofLastMinute'),
                'ofLast15Minutes' => __('filament-date-scopes-filter::date-scope.Minutes.ofLast15Minutes'),
                'ofLast30Minutes' => __('filament-date-scopes-filter::date-scope.Minutes.ofLast30Minutes'),
                'ofLast45Minutes' => __('filament-date-scopes-filter::date-scope.Minutes.ofLast45Minutes'),
                'ofLast60Minutes' => __('filament-date-scopes-filter::date-scope.Minutes.ofLast60Minutes'),
                'ofLastMinutes' => __('filament-date-scopes-filter::date-scope.Minutes.ofLastMinutes'),
            ],
            __('filament-date-scopes-filter::date-scope.Hours.label') => [
                'ofLastHour' => __('filament-date-scopes-filter::date-scope.Hours.ofLastHour'),
                'ofLast6Hours' => __('filament-date-scopes-filter::date-scope.Hours.ofLast6Hours'),
                'ofLast12Hours' => __('filament-date-scopes-filter::date-scope.Hours.ofLast12Hours'),
                'ofLast18Hours' => __('filament-date-scopes-filter::date-scope.Hours.ofLast18Hours'),
                'ofLast24Hours' => __('filament-date-scopes-filter::date-scope.Hours.ofLast24Hours'),
                'ofLastHours' => __('filament-date-scopes-filter::date-scope.Hours.ofLastHours'),
            ],
            __('filament-date-scopes-filter::date-scope.Hours.label') => [
                'ofLastHour' => __('filament-date-scopes-filter::date-scope.Hours.ofLastHour'),
                'ofLast6Hours' => __('filament-date-scopes-filter::date-scope.Hours.ofLast6Hours'),
                'ofLast12Hours' => __('filament-date-scopes-filter::date-scope.Hours.ofLast12Hours'),
                'ofLast18Hours' => __('filament-date-scopes-filter::date-scope.Hours.ofLast18Hours'),
                'ofLast24Hours' => __('filament-date-scopes-filter::date-scope.Hours.ofLast24Hours'),
                'ofLastHours' => __('filament-date-scopes-filter::date-scope.Hours.ofLastHours'),
            ],
            __('filament-date-scopes-filter::date-scope.Days.label') => [
                'ofToday' => __('filament-date-scopes-filter::date-scope.Days.ofToday'),
                'ofYesterday' => __('filament-date-scopes-filter::date-scope.Days.ofYesterday'),
                'ofLast7Days' => __('filament-date-scopes-filter::date-scope.Days.ofLast7Days'),
                'ofLast21Days' => __('filament-date-scopes-filter::date-scope.Days.ofLast21Days'),
                'ofLast30Days' => __('filament-date-scopes-filter::date-scope.Days.ofLast30Days'),
                'ofLastDays' => __('filament-date-scopes-filter::date-scope.Days.ofLastDays'),
            ],
            __('filament-date-scopes-filter::date-scope.Weeks.label') => [
                'ofLastWeek' => __('filament-date-scopes-filter::date-scope.Weeks.ofLastWeek'),
                'ofLast2Weeks' => __('filament-date-scopes-filter::date-scope.Weeks.ofLast2Weeks'),
                'ofLast3Weeks' => __('filament-date-scopes-filter::date-scope.Weeks.ofLast3Weeks'),
                'ofLast4Weeks' => __('filament-date-scopes-filter::date-scope.Weeks.ofLast4Weeks'),
                'ofLastWeeks' => __('filament-date-scopes-filter::date-scope.Weeks.ofLastWeeks'),
            ],
            __('filament-date-scopes-filter::date-scope.Months.label') => [
                'ofLastMonth' => __('filament-date-scopes-filter::date-scope.Months.ofLastMonth'),
                'ofLast3Months' => __('filament-date-scopes-filter::date-scope.Months.ofLast3Months'),
                'ofLast6Months' => __('filament-date-scopes-filter::date-scope.Months.ofLast6Months'),
                'ofLast9Months' => __('filament-date-scopes-filter::date-scope.Months.ofLast9Months'),
                'ofLast12Months' => __('filament-date-scopes-filter::date-scope.Months.ofLast12Months'),
                'ofLastMonths' => __('filament-date-scopes-filter::date-scope.Months.ofLastMonths'),
            ],
            __('filament-date-scopes-filter::date-scope.Quarters.label') => [
                'ofLastQuarter' => __('filament-date-scopes-filter::date-scope.Quarters.ofLastQuarter'),
                'ofLast2Quarters' => __('filament-date-scopes-filter::date-scope.Quarters.ofLast2Quarters'),
                'ofLast3Quarters' => __('filament-date-scopes-filter::date-scope.Quarters.ofLast3Quarters'),
                'ofLast4Quarters' => __('filament-date-scopes-filter::date-scope.Quarters.ofLast4Quarters'),
                'ofLastQuarters' => __('filament-date-scopes-filter::date-scope.Quarters.ofLastQuarters'),
            ],
            __('filament-date-scopes-filter::date-scope.Years.label') => [
                'ofLastYear' => __('filament-date-scopes-filter::date-scope.Years.ofLastYear'),
                'ofLastYears' => __('filament-date-scopes-filter::date-scope.Years.ofLastYears'),
            ],
            __('filament-date-scopes-filter::date-scope.Decades.label') => [
                'ofLastDecade' => __('filament-date-scopes-filter::date-scope.Decades.ofLastDecade'),
                'ofLastDecades' => __('filament-date-scopes-filter::date-scope.Decades.ofLastDecades'),
            ],
            __('filament-date-scopes-filter::date-scope.Centuries.label') => [
                'ofLastCentury' => __('filament-date-scopes-filter::date-scope.Centuries.ofLastCentury'),
                'ofLastCenturies' => __('filament-date-scopes-filter::date-scope.Centuries.ofLastCenturies'),
            ],
            __('filament-date-scopes-filter::date-scope.Millenniums.label') => [
                'ofLastMillennium' => __('filament-date-scopes-filter::date-scope.Millenniums.ofLastMillennium'),
                'ofLastMillenniums' => __('filament-date-scopes-filter::date-scope.Millenniums.ofLastMillenniums'),
            ],
            __('filament-date-scopes-filter::date-scope.toNow/toDate.label') => [
                'secondToNow' => __('filament-date-scopes-filter::date-scope.toNow/toDate.secondToNow'),
                'minuteToNow' => __('filament-date-scopes-filter::date-scope.toNow/toDate.minuteToNow'),
                'hourToNow' => __('filament-date-scopes-filter::date-scope.toNow/toDate.hourToNow'),
                'dayToNow' => __('filament-date-scopes-filter::date-scope.toNow/toDate.dayToNow'),
                'weekToDate' => __('filament-date-scopes-filter::date-scope.toNow/toDate.weekToDate'),
                'monthToDate' => __('filament-date-scopes-filter::date-scope.toNow/toDate.monthToDate'),
                'quarterToDate' => __('filament-date-scopes-filter::date-scope.toNow/toDate.quarterToDate'),
                'yearToDate' => __('filament-date-scopes-filter::date-scope.toNow/toDate.yearToDate'),
                'decadeToDate' => __('filament-date-scopes-filter::date-scope.toNow/toDate.decadeToDate'),
                'centuryToDate' => __('filament-date-scopes-filter::date-scope.toNow/toDate.centuryToDate'),
                'millenniumToDate' => __('filament-date-scopes-filter::date-scope.toNow/toDate.millenniumToDate'),
            ],
        ];
    }

    private array $scopesRequireAdditionalParameters = [
        'ofLastSeconds',
        'ofLastMinutes',
        'ofLastHours',
        'ofLastDays',
        'ofLastWeeks',
        'ofLastMonths',
        'ofLastQuarters',
        'ofLastYears',
        'ofLastDecades',
        'ofLastCenturies',
        'ofLastMillenniums',
    ];

    private array $scopesDontSupportRange = [
        'ofJustNow',
        'ofLastSecond',
        'ofLastMinute',
        'ofLastHour',
        'ofToday',
        'ofYesterday',
        'ofLastWeek',
        'ofLastMonth',
        'ofLastQuarter',
        'ofLastYear',
        'ofLastDecade',
        'ofLastCentury',
        'ofLastMillennium',
        'secondToNow',
        'minuteToNow',
        'hourToNow',
        'dayToNow',
        'weekToDate',
        'monthToDate',
        'quarterToDate',
        'yearToDate',
        'decadeToDate',
        'centuryToDate',
        'millenniumToDate',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->form(fn () => [
            Grid::make($this->getColumns())->schema([
                Select::make($this->getName())
                    ->options($this->scopes())
                    ->searchable()
                    ->reactive(),
                TextInput::make('additional_parameter')
                    ->label(function (Get $get) {
                        $words = preg_split('/(?=[A-Z])/', $get($this->getName()), -1, PREG_SPLIT_NO_EMPTY);
                        $lastWord = end($words);

                        return __('Number of '.$lastWord);
                    })
                    ->default(2)
                    ->numeric()
                    ->visible(function (Get $get) {
                        return (bool) in_array($get($this->getName()), $this->scopesRequireAdditionalParameters);
                    }),
                Select::make('range')
                    ->options(function () {
                        return collect(DateRange::cases())->mapWithKeys(function ($dateRange) {
                            return [$dateRange->value => $dateRange->name];
                        })->toArray();
                    })
                    ->searchable()
                    ->visible(function (Get $get) {
                        return (bool) (! is_null($get($this->getName())) && ! in_array($get($this->getName()), $this->scopesDontSupportRange));
                    })
                    ->default(DateRange::EXCLUSIVE->value),
            ]),
        ])->query(function (Builder $query, array $data) {
            return $query->when($data[$this->getName()] ?? null, function ($query, $value) use ($data) {
                if (in_array($value, $this->scopesRequireAdditionalParameters)) {
                    $parameterValue = (! is_null($data['additional_parameter']) && intval($data['additional_parameter']) >= 1)
                        ? $data['additional_parameter']
                        : 1;
                    if (! in_array($data[$this->getName()], $this->scopesDontSupportRange)) {
                        return $query->{$value}(intval($parameterValue), customRange: DateRange::tryFrom($data['range']));
                    } else {
                        return $query->{$value}(intval($parameterValue));
                    }
                }

                if (! in_array($data[$this->getName()], $this->scopesDontSupportRange)) {
                    return $query->{$value}(customRange: DateRange::tryFrom($data['range']));
                } else {
                    return $query->{$value}();
                }
            });
        });

        $this->indicateUsing(function (array $data): array {
            $indicators = [];

            if ($data[$this->getName()] ?? null) {
                $label = $this->getLabel();
                $indicators[] = Indicator::make($label.' : '.$this->getScopeValue($data[$this->getName()]))
                    ->removeField($this->getName());
            }

            return $indicators;
        });
    }

    public function getScopeValue(string $key): ?string
    {

        foreach ($this->scopes() as $group) {
            if (array_key_exists($key, $group)) {
                return $group[$key];
            }
        }

        return null;
    }
}
