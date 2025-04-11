<?php

namespace AymanAlhattami\FilamentDateScopesFilter;

use Closure;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Get;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use LaracraftTech\LaravelDateScopes\DateRange;

class DateScopeFilter extends Filter
{
    protected bool|Closure $wrapInFieldset = false;

    /** @var array|Closure <int, ScopeType> */
    protected array|Closure $withoutScopes = [];

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
        'custom',
    ];

    public function withoutScopes(DateScope|array|Closure $scope): static
    {
        if ($scope instanceof DateScope || $scope instanceof Closure) {
            $this->withoutScopes[] = $scope;
        } else {
            $this->withoutScopes = array_merge($this->withoutScopes, $scope);
        }

        return $this;
    }

    public function withoutSeconds(): static
    {
        return $this->withoutScopes([
            DateScope::OfJustNow,
            DateScope::OfLastSecond,
            DateScope::OfLast15Seconds,
            DateScope::OfLast30Seconds,
            DateScope::OfLast45Seconds,
            DateScope::OfLast60Seconds,
            DateScope::OfLastSeconds,
        ]);
    }

    public function withoutMinutes(): static
    {
        return $this->withoutScopes([
            DateScope::MinuteToNow,
            DateScope::OfLastMinute,
            DateScope::OfLast15Minutes,
            DateScope::OfLast30Minutes,
            DateScope::OfLast45Minutes,
            DateScope::OfLast60Minutes,
            DateScope::OfLastMinutes,
        ]);
    }

    public function withoutHours(): static
    {
        return $this->withoutScopes([
            DateScope::HourToNow,
            DateScope::OfLastHour,
            DateScope::OfLast6Hours,
            DateScope::OfLast12Hours,
            DateScope::OfLast18Hours,
            DateScope::OfLast24Hours,
            DateScope::OfLastHours,
        ]);
    }

    public function withoutDays(): static
    {
        return $this->withoutScopes([
            DateScope::DayToNow,
            DateScope::OfToday,
            DateScope::OfYesterday,
            DateScope::OfLast7Days,
            DateScope::OfLast21Days,
            DateScope::OfLast30Days,
            DateScope::OfLastDays,
        ]);
    }

    public function withoutWeeks(): static
    {
        return $this->withoutScopes([
            DateScope::WeekToDate,
            DateScope::OfLastWeek,
            DateScope::OfLast2Weeks,
            DateScope::OfLast3Weeks,
            DateScope::OfLast4Weeks,
            DateScope::OfLastWeeks,
        ]);
    }

    public function withoutMonths(): static
    {
        return $this->withoutScopes([
            DateScope::MonthToDate,
            DateScope::OfLastMonth,
            DateScope::OfLast3Months,
            DateScope::OfLast6Months,
            DateScope::OfLast9Months,
            DateScope::OfLast12Months,
            DateScope::OfLastMonths,
        ]);
    }

    public function withoutQuarters(): static
    {
        return $this->withoutScopes([
            DateScope::QuarterToDate,
            DateScope::OfLastQuarter,
            DateScope::OfLast2Quarters,
            DateScope::OfLast3Quarters,
            DateScope::OfLast4Quarters,
            DateScope::OfLastQuarters,
        ]);
    }

    public function withoutYears(): static
    {
        return $this->withoutScopes([
            DateScope::YearToDate,
            DateScope::OfLastYear,
            DateScope::OfLastYears,
        ]);
    }

    public function withoutDecades(): static
    {
        return $this->withoutScopes([
            DateScope::DecadeToDate,
            DateScope::OfLastDecade,
            DateScope::OfLastDecades,
        ]);
    }

    public function withoutCenturies(): static
    {
        return $this->withoutScopes([
            DateScope::CenturyToDate,
            DateScope::OfLastCentury,
            DateScope::OfLastCenturies,
        ]);
    }

    public function withoutMillenniums(): static
    {
        return $this->withoutScopes([
            DateScope::MillenniumToDate,
            DateScope::OfLastMillennium,
            DateScope::OfLastMillenniums,
        ]);
    }

    public function withoutCustom(): static
    {
        return $this->withoutScopes(DateScope::Custom,);
    }

    private function getWithoutScopes(): array
    {
        return $this->evaluate($this->withoutScopes);
    }

    private function getAllScopes(): array
    {
        return [
            ScopeGroup::Seconds->value => [
                'label' => __('filament-date-scopes-filter::date-scope.seconds.label'),
                'scopes' => [
                    //                    'secondToNow' => __('filament-date-scopes-filter::date-scope.seconds.secondToNow'), // query transactions created during the start of the current second till now (equivalent of just now)
                    DateScope::OfJustNow->value => __('filament-date-scopes-filter::date-scope.seconds.ofJustNow'),
                    'ofLastSecond' => __('filament-date-scopes-filter::date-scope.seconds.ofLastSecond'),
                    'ofLast15Seconds' => __('filament-date-scopes-filter::date-scope.seconds.ofLast15Seconds'),
                    'ofLast30Seconds' => __('filament-date-scopes-filter::date-scope.seconds.ofLast30Seconds'),
                    'ofLast45Seconds' => __('filament-date-scopes-filter::date-scope.seconds.ofLast45Seconds'),
                    'ofLast60Seconds' => __('filament-date-scopes-filter::date-scope.seconds.ofLast60Seconds'),
                    'ofLastSeconds' => __('filament-date-scopes-filter::date-scope.seconds.ofLastSeconds'),
                ],
            ],
            ScopeGroup::Minutes->value => [
                'label' => __('filament-date-scopes-filter::date-scope.minutes.label'),
                'scopes' => [
                    'minuteToNow' => __('filament-date-scopes-filter::date-scope.minutes.minuteToNow'),
                    'ofLastMinute' => __('filament-date-scopes-filter::date-scope.minutes.ofLastMinute'),
                    'ofLast15Minutes' => __('filament-date-scopes-filter::date-scope.minutes.ofLast15Minutes'),
                    'ofLast30Minutes' => __('filament-date-scopes-filter::date-scope.minutes.ofLast30Minutes'),
                    'ofLast45Minutes' => __('filament-date-scopes-filter::date-scope.minutes.ofLast45Minutes'),
                    'ofLast60Minutes' => __('filament-date-scopes-filter::date-scope.minutes.ofLast60Minutes'),
                    'ofLastMinutes' => __('filament-date-scopes-filter::date-scope.minutes.ofLastMinutes'),
                ],
            ],
            ScopeGroup::Hours->value => [
                'label' => __('filament-date-scopes-filter::date-scope.hours.label'),
                'scopes' => [
                    'hourToNow' => __('filament-date-scopes-filter::date-scope.hours.hourToNow'),
                    'ofLastHour' => __('filament-date-scopes-filter::date-scope.hours.ofLastHour'),
                    'ofLast6Hours' => __('filament-date-scopes-filter::date-scope.hours.ofLast6Hours'),
                    'ofLast12Hours' => __('filament-date-scopes-filter::date-scope.hours.ofLast12Hours'),
                    'ofLast18Hours' => __('filament-date-scopes-filter::date-scope.hours.ofLast18Hours'),
                    'ofLast24Hours' => __('filament-date-scopes-filter::date-scope.hours.ofLast24Hours'),
                    'ofLastHours' => __('filament-date-scopes-filter::date-scope.hours.ofLastHours'),
                ],
            ],
            ScopeGroup::Days->value => [
                'label' => __('filament-date-scopes-filter::date-scope.days.label'),
                'scopes' => [
                    'dayToNow' => __('filament-date-scopes-filter::date-scope.days.dayToNow'),
                    'ofToday' => __('filament-date-scopes-filter::date-scope.days.ofToday'),
                    'ofYesterday' => __('filament-date-scopes-filter::date-scope.days.ofYesterday'),
                    'ofLast7Days' => __('filament-date-scopes-filter::date-scope.days.ofLast7Days'),
                    'ofLast21Days' => __('filament-date-scopes-filter::date-scope.days.ofLast21Days'),
                    'ofLast30Days' => __('filament-date-scopes-filter::date-scope.days.ofLast30Days'),
                    'ofLastDays' => __('filament-date-scopes-filter::date-scope.days.ofLastDays'),
                ],
            ],
            ScopeGroup::Weeks->value => [
                'label' => __('filament-date-scopes-filter::date-scope.weeks.label'),
                'scopes' => [
                    'weekToDate' => __('filament-date-scopes-filter::date-scope.weeks.weekToDate'),
                    'ofLastWeek' => __('filament-date-scopes-filter::date-scope.weeks.ofLastWeek'),
                    'ofLast2Weeks' => __('filament-date-scopes-filter::date-scope.weeks.ofLast2Weeks'),
                    'ofLast3Weeks' => __('filament-date-scopes-filter::date-scope.weeks.ofLast3Weeks'),
                    'ofLast4Weeks' => __('filament-date-scopes-filter::date-scope.weeks.ofLast4Weeks'),
                    'ofLastWeeks' => __('filament-date-scopes-filter::date-scope.weeks.ofLastWeeks'),
                ],
            ],
            ScopeGroup::Months->value => [
                'label' => __('filament-date-scopes-filter::date-scope.months.label'),
                'scopes' => [
                    'monthToDate' => __('filament-date-scopes-filter::date-scope.months.monthToDate'),
                    'ofLastMonth' => __('filament-date-scopes-filter::date-scope.months.ofLastMonth'),
                    'ofLast3Months' => __('filament-date-scopes-filter::date-scope.months.ofLast3Months'),
                    'ofLast6Months' => __('filament-date-scopes-filter::date-scope.months.ofLast6Months'),
                    'ofLast9Months' => __('filament-date-scopes-filter::date-scope.months.ofLast9Months'),
                    'ofLast12Months' => __('filament-date-scopes-filter::date-scope.months.ofLast12Months'),
                    'ofLastMonths' => __('filament-date-scopes-filter::date-scope.months.ofLastMonths'),
                ],
            ],
            ScopeGroup::Quarters->value => [
                'label' => __('filament-date-scopes-filter::date-scope.quarters.label'),
                'scopes' => [
                    'quarterToDate' => __('filament-date-scopes-filter::date-scope.quarters.quarterToDate'),
                    'ofLastQuarter' => __('filament-date-scopes-filter::date-scope.quarters.ofLastQuarter'),
                    'ofLast2Quarters' => __('filament-date-scopes-filter::date-scope.quarters.ofLast2Quarters'),
                    'ofLast3Quarters' => __('filament-date-scopes-filter::date-scope.quarters.ofLast3Quarters'),
                    'ofLast4Quarters' => __('filament-date-scopes-filter::date-scope.quarters.ofLast4Quarters'),
                    'ofLastQuarters' => __('filament-date-scopes-filter::date-scope.quarters.ofLastQuarters'),
                ],
            ],
            ScopeGroup::Years->value => [
                'label' => __('filament-date-scopes-filter::date-scope.years.label'),
                'scopes' => [
                    'yearToDate' => __('filament-date-scopes-filter::date-scope.years.yearToDate'),
                    'ofLastYear' => __('filament-date-scopes-filter::date-scope.years.ofLastYear'),
                    'ofLastYears' => __('filament-date-scopes-filter::date-scope.years.ofLastYears'),
                ],
            ],
            ScopeGroup::Decades->value => [
                'label' => __('filament-date-scopes-filter::date-scope.decades.label'),
                'scopes' => [
                    'decadeToDate' => __('filament-date-scopes-filter::date-scope.decades.decadeToDate'),
                    'ofLastDecade' => __('filament-date-scopes-filter::date-scope.decades.ofLastDecade'),
                    'ofLastDecades' => __('filament-date-scopes-filter::date-scope.decades.ofLastDecades'),
                ],
            ],
            ScopeGroup::Centuries->value => [
                'label' => __('filament-date-scopes-filter::date-scope.centuries.label'),
                'scopes' => [
                    'centuryToDate' => __('filament-date-scopes-filter::date-scope.centuries.centuryToDate'),
                    'ofLastCentury' => __('filament-date-scopes-filter::date-scope.centuries.ofLastCentury'),
                    'ofLastCenturies' => __('filament-date-scopes-filter::date-scope.centuries.ofLastCenturies'),
                ],
            ],
            ScopeGroup::Millenniums->value => [
                'label' => __('filament-date-scopes-filter::date-scope.millenniums.label'),
                'scopes' => [
                    'millenniumToDate' => __('filament-date-scopes-filter::date-scope.millenniums.millenniumToDate'),
                    'ofLastMillennium' => __('filament-date-scopes-filter::date-scope.millenniums.ofLastMillennium'),
                    'ofLastMillenniums' => __('filament-date-scopes-filter::date-scope.millenniums.ofLastMillenniums'),
                ],
            ],
            ScopeGroup::Custom->value => [
                'label' => __('filament-date-scopes-filter::date-scope.custom.custom'),
                'scopes' => [
                    'custom' => __('filament-date-scopes-filter::date-scope.custom.custom'),
                ],
            ],
        ];
    }

    private function getEnabledScopesAsGroups(): array
    {
        $enabledScopes = [];

        foreach ($this->getAllScopes() as $groupName => $scopes) {
            $groupScopes = [];
            foreach ($scopes['scopes'] as $scopeName => $scopeValue) {
                if (! in_array(DateScope::tryFrom($scopeName), $this->getWithoutScopes(), true)) {
                    $groupScopes[] = $scopeValue;
                }
            }

            $enabledScopes[__('filament-date-scopes-filter::date-scope.' . $groupName . '.plural_label')] = $groupScopes;
        }

        return $enabledScopes;
    }

    public function wrapInFieldset($value = true): static
    {
        $this->wrapInFieldset = $value;

        return $this;
    }

    private function isWrapInFieldset(): bool
    {
        return $this->evaluate($this->wrapInFieldset);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->form(fn () => [
            Fieldset::make($this->getName())
                ->label($this->getLabel())
                ->schema($this->getSearchFormFields())
                ->visible($this->isWrapInFieldset()),
            Grid::make($this->getColumns())
                ->label($this->getLabel())
                ->schema($this->getSearchFormFields())
                ->visible(! $this->isWrapInFieldset()),
        ])->query(function (Builder $query, array $data) {
            return $query->when($this->getNameValue($data) ?? null, function ($query, $scope) use ($data) {
                $query->when($scope === ScopeGroup::Custom->value, function ($query) use ($data) {
                    $query->when($data['from_date'] ?? null, function ($query, $fromDate) {
                        $query->whereDate($this->getName(), '>=', $fromDate);
                    })->when($data['to_date'] ?? null, function ($query, $toDate) {
                        $query->whereDate($this->getName(), '<=', $toDate);
                    });
                });

                $query->unless($this->getNameValue($data) === ScopeGroup::Custom->value, function ($query, $value) use ($scope, $data) {
                    // TODO refactor: use when instead of if
                    if (in_array($scope, $this->scopesRequireAdditionalParameters, true)) {
                        $parameterValue = (! is_null($data['additional_parameter']) && (int) $data['additional_parameter'] >= 1)
                            ? $data['additional_parameter']
                            : 1;
                        if (! in_array($this->getNameValue($data), $this->scopesDontSupportRange, true)) {
                            return $query->{$scope}((int) $parameterValue, customRange: DateRange::tryFrom($data['range']));
                        }

                        return $query->{$scope}((int) $parameterValue);
                    }

                    if (! in_array($this->getNameValue($data), $this->scopesDontSupportRange, true)) {
                        return $query->{$scope}(customRange: DateRange::tryFrom($data['range']));
                    }

                    return $query->{$scope}();
                });
            });
        });

//        $this->indicateUsing(function (array $data): array {
//            $indicators = [];
//
//            if ($this->getNameValue($data) ?? null) {
//                $label = $this->getLabel();
//                $indicators[] = Indicator::make($label.' : '.$this->getScopeValue($this->getNameValue($data)))
//                    ->removeField($this->getName());
//            }
//
//            return $indicators;
//        });
    }

    private function getSearchFormFields(): array
    {
        return [
            Select::make($this->getName())
                ->label($this->getLabel())
                ->options($this->getEnabledScopesAsGroups())
                ->searchable()
                ->live()
                ->default($this->getDefaultState()),
            TextInput::make('additional_parameter')
                ->label(function (Get $get) {
                    $words = preg_split('/(?=[A-Z])/', $get($this->getName()), -1, PREG_SPLIT_NO_EMPTY);
                    $lastWord = str(end($words))->lower();

                    return __('filament-date-scopes-filter::date-scope.Number of').' '.__('filament-date-scopes-filter::date-scope.'.$lastWord.'.plural_label');
                })
                ->default(2)
                ->numeric()
                ->visible(function (Get $get) {
                    return in_array($get($this->getName()), $this->scopesRequireAdditionalParameters, true);
                }),
            ToggleButtons::make('range')
                ->options([
                    DateRange::INCLUSIVE->value => __('filament-date-scopes-filter::date-scope.yes'),
                    DateRange::EXCLUSIVE->value => __('filament-date-scopes-filter::date-scope.no'),
                ])
                ->label(function (Get $get) {
                    $words = preg_split('/(?=[A-Z])/', $get($this->getName()), -1, PREG_SPLIT_NO_EMPTY);
                    $lastWord = str(end($words))->lower();

                    return __('filament-date-scopes-filter::date-scope.Include').' '.__('filament-date-scopes-filter::date-scope.'.$lastWord.'.current');
                })
                ->grouped()
                ->visible(function (Get $get) {
                    return ! is_null($get($this->getName())) && ! in_array($get($this->getName()), $this->scopesDontSupportRange, true);
                })
                ->default(DateRange::EXCLUSIVE->value),
            DatePicker::make('from_date')
                ->visible(fn (Get $get) => $get($this->getName()) === ScopeGroup::Custom->value)
                ->label(__('filament-date-scopes-filter::date-scope.from_date')),
            DatePicker::make('to_date')
                ->visible(fn (Get $get) => $get($this->getName()) === ScopeGroup::Custom->value)
                ->label(__('filament-date-scopes-filter::date-scope.to_date')),
        ];
    }

    public function getScopeValue(string $key): ?string
    {
        foreach ($this->getEnabledScopesAsGroups() as $group) {
            if (array_key_exists($key, $group)) {
                return $group[$key];
            }
        }

        return null;
    }

    private function getNameValue(array $data): ?string
    {
        $keys = explode('.', $this->getName());

        $value = $data;

        foreach ($keys as $key) {
            if (isset($value[$key])) {
                $value = $value[$key];
            } else {
                $value = null;
                break;
            }
        }

        return $value;
    }
}
