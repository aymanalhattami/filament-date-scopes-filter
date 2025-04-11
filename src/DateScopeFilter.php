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
                    DateScope::OfLastSecond->value => __('filament-date-scopes-filter::date-scope.seconds.ofLastSecond'),
                    DateScope::OfLast15Seconds->value => __('filament-date-scopes-filter::date-scope.seconds.ofLast15Seconds'),
                    DateScope::OfLast30Seconds->value => __('filament-date-scopes-filter::date-scope.seconds.ofLast30Seconds'),
                    DateScope::OfLast45Seconds->value => __('filament-date-scopes-filter::date-scope.seconds.ofLast45Seconds'),
                    DateScope::OfLast60Seconds->value => __('filament-date-scopes-filter::date-scope.seconds.ofLast60Seconds'),
                    DateScope::OfLastSeconds->value => __('filament-date-scopes-filter::date-scope.seconds.ofLastSeconds'),
                ],
            ],
            ScopeGroup::Minutes->value => [
                'label' => __('filament-date-scopes-filter::date-scope.minutes.label'),
                'scopes' => [
                    DateScope::MinuteToNow->value => __('filament-date-scopes-filter::date-scope.minutes.minuteToNow'),
                    DateScope::OfLastMinute->value => __('filament-date-scopes-filter::date-scope.minutes.ofLastMinute'),
                    DateScope::OfLast15Minutes->value => __('filament-date-scopes-filter::date-scope.minutes.ofLast15Minutes'),
                    DateScope::OfLast30Minutes->value => __('filament-date-scopes-filter::date-scope.minutes.ofLast30Minutes'),
                    DateScope::OfLast45Minutes->value => __('filament-date-scopes-filter::date-scope.minutes.ofLast45Minutes'),
                    DateScope::OfLast60Minutes->value => __('filament-date-scopes-filter::date-scope.minutes.ofLast60Minutes'),
                    DateScope::OfLastMinutes->value => __('filament-date-scopes-filter::date-scope.minutes.ofLastMinutes'),
                ],
            ],
            ScopeGroup::Hours->value => [
                'label' => __('filament-date-scopes-filter::date-scope.hours.label'),
                'scopes' => [
                    DateScope::HourToNow->value => __('filament-date-scopes-filter::date-scope.hours.hourToNow'),
                    DateScope::OfLastHour->value => __('filament-date-scopes-filter::date-scope.hours.ofLastHour'),
                    DateScope::OfLast6Hours->value => __('filament-date-scopes-filter::date-scope.hours.ofLast6Hours'),
                    DateScope::OfLast12Hours->value => __('filament-date-scopes-filter::date-scope.hours.ofLast12Hours'),
                    DateScope::OfLast18Hours->value => __('filament-date-scopes-filter::date-scope.hours.ofLast18Hours'),
                    DateScope::OfLast24Hours->value => __('filament-date-scopes-filter::date-scope.hours.ofLast24Hours'),
                    DateScope::OfLastHours->value => __('filament-date-scopes-filter::date-scope.hours.ofLastHours'),
                ],
            ],
            ScopeGroup::Days->value => [
                'label' => __('filament-date-scopes-filter::date-scope.days.label'),
                'scopes' => [
                    DateScope::DayToNow->value => __('filament-date-scopes-filter::date-scope.days.dayToNow'),
                    DateScope::OfToday->value => __('filament-date-scopes-filter::date-scope.days.ofToday'),
                    DateScope::OfYesterday->value => __('filament-date-scopes-filter::date-scope.days.ofYesterday'),
                    DateScope::OfLast7Days->value => __('filament-date-scopes-filter::date-scope.days.ofLast7Days'),
                    DateScope::OfLast21Days->value => __('filament-date-scopes-filter::date-scope.days.ofLast21Days'),
                    DateScope::OfLast30Days->value => __('filament-date-scopes-filter::date-scope.days.ofLast30Days'),
                    DateScope::OfLastDays->value => __('filament-date-scopes-filter::date-scope.days.ofLastDays'),
                ],
            ],
            ScopeGroup::Weeks->value => [
                'label' => __('filament-date-scopes-filter::date-scope.weeks.label'),
                'scopes' => [
                    DateScope::WeekToDate->value => __('filament-date-scopes-filter::date-scope.weeks.weekToDate'),
                    DateScope::OfLastWeek->value => __('filament-date-scopes-filter::date-scope.weeks.ofLastWeek'),
                    DateScope::OfLast2Weeks->value => __('filament-date-scopes-filter::date-scope.weeks.ofLast2Weeks'),
                    DateScope::OfLast3Weeks->value => __('filament-date-scopes-filter::date-scope.weeks.ofLast3Weeks'),
                    DateScope::OfLast4Weeks->value => __('filament-date-scopes-filter::date-scope.weeks.ofLast4Weeks'),
                    DateScope::OfLastWeeks->value => __('filament-date-scopes-filter::date-scope.weeks.ofLastWeeks'),
                ],
            ],
            ScopeGroup::Months->value => [
                'label' => __('filament-date-scopes-filter::date-scope.months.label'),
                'scopes' => [
                    DateScope::MonthToDate->value => __('filament-date-scopes-filter::date-scope.months.monthToDate'),
                    DateScope::OfLastMonth->value => __('filament-date-scopes-filter::date-scope.months.ofLastMonth'),
                    DateScope::OfLast3Months->value => __('filament-date-scopes-filter::date-scope.months.ofLast3Months'),
                    DateScope::OfLast6Months->value => __('filament-date-scopes-filter::date-scope.months.ofLast6Months'),
                    DateScope::OfLast9Months->value => __('filament-date-scopes-filter::date-scope.months.ofLast9Months'),
                    DateScope::OfLast12Months->value => __('filament-date-scopes-filter::date-scope.months.ofLast12Months'),
                    DateScope::OfLastMonths->value => __('filament-date-scopes-filter::date-scope.months.ofLastMonths'),
                ],
            ],
            ScopeGroup::Quarters->value => [
                'label' => __('filament-date-scopes-filter::date-scope.quarters.label'),
                'scopes' => [
                    DateScope::QuarterToDate->value => __('filament-date-scopes-filter::date-scope.quarters.quarterToDate'),
                    DateScope::OfLastQuarter->value => __('filament-date-scopes-filter::date-scope.quarters.ofLastQuarter'),
                    DateScope::OfLast2Quarters->value => __('filament-date-scopes-filter::date-scope.quarters.ofLast2Quarters'),
                    DateScope::OfLast3Quarters->value => __('filament-date-scopes-filter::date-scope.quarters.ofLast3Quarters'),
                    DateScope::OfLast4Quarters->value => __('filament-date-scopes-filter::date-scope.quarters.ofLast4Quarters'),
                    DateScope::OfLastQuarters->value => __('filament-date-scopes-filter::date-scope.quarters.ofLastQuarters'),
                ],
            ],
            ScopeGroup::Years->value => [
                'label' => __('filament-date-scopes-filter::date-scope.years.label'),
                'scopes' => [
                    DateScope::YearToDate->value => __('filament-date-scopes-filter::date-scope.years.yearToDate'),
                    DateScope::OfLastYear->value => __('filament-date-scopes-filter::date-scope.years.ofLastYear'),
                    DateScope::OfLastYears->value => __('filament-date-scopes-filter::date-scope.years.ofLastYears'),
                ],
            ],
            ScopeGroup::Decades->value => [
                'label' => __('filament-date-scopes-filter::date-scope.decades.label'),
                'scopes' => [
                    DateScope::DecadeToDate->value => __('filament-date-scopes-filter::date-scope.decades.decadeToDate'),
                    DateScope::OfLastDecade->value => __('filament-date-scopes-filter::date-scope.decades.ofLastDecade'),
                    DateScope::OfLastDecades->value => __('filament-date-scopes-filter::date-scope.decades.ofLastDecades'),
                ],
            ],
            ScopeGroup::Centuries->value => [
                'label' => __('filament-date-scopes-filter::date-scope.centuries.label'),
                'scopes' => [
                    DateScope::CenturyToDate->value => __('filament-date-scopes-filter::date-scope.centuries.centuryToDate'),
                    DateScope::OfLastCentury->value => __('filament-date-scopes-filter::date-scope.centuries.ofLastCentury'),
                    DateScope::OfLastCenturies->value => __('filament-date-scopes-filter::date-scope.centuries.ofLastCenturies'),
                ],
            ],
            ScopeGroup::Millenniums->value => [
                'label' => __('filament-date-scopes-filter::date-scope.millenniums.label'),
                'scopes' => [
                    DateScope::MillenniumToDate->value => __('filament-date-scopes-filter::date-scope.millenniums.millenniumToDate'),
                    DateScope::OfLastMillennium->value => __('filament-date-scopes-filter::date-scope.millenniums.ofLastMillennium'),
                    DateScope::OfLastMillenniums->value => __('filament-date-scopes-filter::date-scope.millenniums.ofLastMillenniums'),
                ],
            ],
            ScopeGroup::Custom->value => [
                'label' => __('filament-date-scopes-filter::date-scope.custom.custom'),
                'scopes' => [
                    DateScope::Custom->value => __('filament-date-scopes-filter::date-scope.custom.custom'),
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
                    $groupScopes[$scopeName] = $scopeValue;
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
