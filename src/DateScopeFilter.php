<?php

namespace AymanAlhattami\FilamentDateScopesFilter;

use Closure;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Get;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Illuminate\Database\Eloquent\Builder;
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
    ];

    public function withoutScopes(ScopeType|array|Closure $scope): static
    {
        if ($scope instanceof ScopeType || $scope instanceof Closure) {
            $this->withoutScopes[] = $scope;
        } elseif (is_array($scope)) {
            $this->withoutScopes = array_merge($this->withoutScopes, $scope);
        }

        return $this;
    }

    public function withoutSecond(): static
    {
        return $this->withoutScopes(ScopeType::Second);
    }

    public function withoutMinute(): static
    {
        return $this->withoutScopes(ScopeType::Minute);
    }

    public function withoutHour(): static
    {
        return $this->withoutScopes(ScopeType::Hour);
    }

    public function withoutDay(): static
    {
        return $this->withoutScopes(ScopeType::Day);
    }

    public function withoutWeek(): static
    {
        return $this->withoutScopes(ScopeType::Week);
    }

    public function withoutMonth(): static
    {
        return $this->withoutScopes(ScopeType::Month);
    }

    public function withoutQuarter(): static
    {
        return $this->withoutScopes(ScopeType::Quarter);
    }

    public function withoutYear(): static
    {
        return $this->withoutScopes(ScopeType::Year);
    }

    public function withoutDecade(): static
    {
        return $this->withoutScopes(ScopeType::Decade);
    }

    public function withoutCentury(): static
    {
        return $this->withoutScopes(ScopeType::Century);
    }

    public function withoutMillennium(): static
    {
        return $this->withoutScopes(ScopeType::Millennium);
    }

    public function withoutToNow(): static
    {
        return $this->withoutScopes(ScopeType::ToNow);
    }

    private function getWithoutScopes(): array
    {
        return $this->evaluate($this->withoutScopes);
    }

    private function getAllScopes(): array
    {
        return [
            ScopeType::Second->value => [
                'label' => __('filament-date-scopes-filter::date-scope.seconds.label'),
                'scopes' => [
//                    'secondToNow' => __('filament-date-scopes-filter::date-scope.seconds.secondToNow'), // query transactions created during the start of the current second till now (equivalent of just now)
                    'ofJustNow' => __('filament-date-scopes-filter::date-scope.seconds.ofJustNow'),
                    'ofLastSecond' => __('filament-date-scopes-filter::date-scope.seconds.ofLastSecond'),
                    'ofLast15Seconds' => __('filament-date-scopes-filter::date-scope.seconds.ofLast15Seconds'),
                    'ofLast30Seconds' => __('filament-date-scopes-filter::date-scope.seconds.ofLast30Seconds'),
                    'ofLast45Seconds' => __('filament-date-scopes-filter::date-scope.seconds.ofLast45Seconds'),
                    'ofLast60Seconds' => __('filament-date-scopes-filter::date-scope.seconds.ofLast60Seconds'),
                    'ofLastSeconds' => __('filament-date-scopes-filter::date-scope.seconds.ofLastSeconds'),
                ],
            ],
            ScopeType::Minute->value => [
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
            ScopeType::Hour->value => [
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
            ScopeType::Day->value => [
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
            ScopeType::Week->value => [
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
            ScopeType::Month->value => [
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
            ScopeType::Quarter->value => [
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
            ScopeType::Year->value => [
                'label' => __('filament-date-scopes-filter::date-scope.years.label'),
                'scopes' => [
                    'yearToDate' => __('filament-date-scopes-filter::date-scope.years.yearToDate'),
                    'ofLastYear' => __('filament-date-scopes-filter::date-scope.years.ofLastYear'),
                    'ofLastYears' => __('filament-date-scopes-filter::date-scope.years.ofLastYears'),
                ],
            ],
            ScopeType::Decade->value => [
                'label' => __('filament-date-scopes-filter::date-scope.decades.label'),
                'scopes' => [
                    'decadeToDate' => __('filament-date-scopes-filter::date-scope.decades.decadeToDate'),
                    'ofLastDecade' => __('filament-date-scopes-filter::date-scope.decades.ofLastDecade'),
                    'ofLastDecades' => __('filament-date-scopes-filter::date-scope.decades.ofLastDecades'),
                ],
            ],
            ScopeType::Century->value => [
                'label' => __('filament-date-scopes-filter::date-scope.centuries.label'),
                'scopes' => [
                    'centuryToDate' => __('filament-date-scopes-filter::date-scope.centuries.centuryToDate'),
                    'ofLastCentury' => __('filament-date-scopes-filter::date-scope.centuries.ofLastCentury'),
                    'ofLastCenturies' => __('filament-date-scopes-filter::date-scope.centuries.ofLastCenturies'),
                ],
            ],
            ScopeType::Millennium->value => [
                'label' => __('filament-date-scopes-filter::date-scope.millenniums.label'),
                'scopes' => [
                    'millenniumToDate' => __('filament-date-scopes-filter::date-scope.millenniums.millenniumToDate'),
                    'ofLastMillennium' => __('filament-date-scopes-filter::date-scope.millenniums.ofLastMillennium'),
                    'ofLastMillenniums' => __('filament-date-scopes-filter::date-scope.millenniums.ofLastMillenniums'),
                ],
            ]
        ];
    }

    private function getEnabledScopes(): array
    {
        $enabledScopes = [];

        foreach ($this->getAllScopes() as $key => $scope) {
            if (! in_array(ScopeType::tryFrom($key), $this->getWithoutScopes(), true)) {
                $enabledScopes[] = $scope;
            }
        }

        return $enabledScopes;
    }

    private function getEnabledScopesAsGroups(): array
    {
        $scopes = [];

        foreach ($this->getEnabledScopes() as $scope) {
            $scopes[$scope['label']] = $scope['scopes'];
        }

        return $scopes;
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
            return $query->when($data[$this->getName()] ?? null, function ($query, $value) use ($data) {
                if (in_array($value, $this->scopesRequireAdditionalParameters, true)) {
                    $parameterValue = (! is_null($data['additional_parameter']) && (int) $data['additional_parameter'] >= 1)
                        ? $data['additional_parameter']
                        : 1;
                    if (! in_array($data[$this->getName()], $this->scopesDontSupportRange, true)) {
                        return $query->{$value}((int) $parameterValue, customRange: DateRange::tryFrom($data['range']));
                    }

                    return $query->{$value}((int) $parameterValue);
                }

                if (! in_array($data[$this->getName()], $this->scopesDontSupportRange, true)) {
                    return $query->{$value}(customRange: DateRange::tryFrom($data['range']));
                }

                return $query->{$value}();
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

    private function getSearchFormFields(): array
    {
        return [
            Select::make($this->getName())
                ->options($this->getEnabledScopesAsGroups())
                ->searchable()
                ->live(),
            TextInput::make('additional_parameter')
                ->label(function (Get $get) {
                    $words = preg_split('/(?=[A-Z])/', $get($this->getName()), -1, PREG_SPLIT_NO_EMPTY);
                    $lastWord = end($words);

                    return __('filament-date-scopes-filter::date-scope.Number of ').__('filament-date-scopes-filter::date-scope.'.$lastWord.'.plural_label');
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
                    $lastWord = end($words);

                    return __('filament-date-scopes-filter::date-scope.Include').' '.__('filament-date-scopes-filter::date-scope.'.$lastWord.'.current');
                })
                ->grouped()
                ->visible(function (Get $get) {
                    return ! is_null($get($this->getName())) && ! in_array($get($this->getName()), $this->scopesDontSupportRange, true);
                })
                ->default(DateRange::EXCLUSIVE->value),
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
}
