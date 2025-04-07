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
                'label' => __('filament-date-scopes-filter::date-scope.Seconds.label'),
                'scopes' => [
                    'ofJustNow' => __('filament-date-scopes-filter::date-scope.Seconds.ofJustNow'),
                    'ofLastSecond' => __('filament-date-scopes-filter::date-scope.Seconds.ofLastSecond'),
                    'ofLast15Seconds' => __('filament-date-scopes-filter::date-scope.Seconds.ofLast15Seconds'),
                    'ofLast30Seconds' => __('filament-date-scopes-filter::date-scope.Seconds.ofLast30Seconds'),
                    'ofLast45Seconds' => __('filament-date-scopes-filter::date-scope.Seconds.ofLast45Seconds'),
                    'ofLast60Seconds' => __('filament-date-scopes-filter::date-scope.Seconds.ofLast60Seconds'),
                    'ofLastSeconds' => __('filament-date-scopes-filter::date-scope.Seconds.ofLastSeconds'),
                ],
            ],
            'minute' => [
                'label' => __('filament-date-scopes-filter::date-scope.Minutes.label'),
                'scopes' => [

                    'ofLastMinute' => __('filament-date-scopes-filter::date-scope.Minutes.ofLastMinute'),
                    'ofLast15Minutes' => __('filament-date-scopes-filter::date-scope.Minutes.ofLast15Minutes'),
                    'ofLast30Minutes' => __('filament-date-scopes-filter::date-scope.Minutes.ofLast30Minutes'),
                    'ofLast45Minutes' => __('filament-date-scopes-filter::date-scope.Minutes.ofLast45Minutes'),
                    'ofLast60Minutes' => __('filament-date-scopes-filter::date-scope.Minutes.ofLast60Minutes'),
                    'ofLastMinutes' => __('filament-date-scopes-filter::date-scope.Minutes.ofLastMinutes'),
                ],
            ],
            'hour' => [
                'label' => __('filament-date-scopes-filter::date-scope.Hours.label'),
                'scopes' => [
                    'ofLastHour' => __('filament-date-scopes-filter::date-scope.Hours.ofLastHour'),
                    'ofLast6Hours' => __('filament-date-scopes-filter::date-scope.Hours.ofLast6Hours'),
                    'ofLast12Hours' => __('filament-date-scopes-filter::date-scope.Hours.ofLast12Hours'),
                    'ofLast18Hours' => __('filament-date-scopes-filter::date-scope.Hours.ofLast18Hours'),
                    'ofLast24Hours' => __('filament-date-scopes-filter::date-scope.Hours.ofLast24Hours'),
                    'ofLastHours' => __('filament-date-scopes-filter::date-scope.Hours.ofLastHours'),
                ],
            ],
            'day' => [
                'label' => __('filament-date-scopes-filter::date-scope.Days.label'),
                'scopes' => [
                    'ofToday' => __('filament-date-scopes-filter::date-scope.Days.ofToday'),
                    'ofYesterday' => __('filament-date-scopes-filter::date-scope.Days.ofYesterday'),
                    'ofLast7Days' => __('filament-date-scopes-filter::date-scope.Days.ofLast7Days'),
                    'ofLast21Days' => __('filament-date-scopes-filter::date-scope.Days.ofLast21Days'),
                    'ofLast30Days' => __('filament-date-scopes-filter::date-scope.Days.ofLast30Days'),
                    'ofLastDays' => __('filament-date-scopes-filter::date-scope.Days.ofLastDays'),
                ],
            ],
            'week' => [
                'label' => __('filament-date-scopes-filter::date-scope.Weeks.label'),
                'scopes' => [
                    'ofLastWeek' => __('filament-date-scopes-filter::date-scope.Weeks.ofLastWeek'),
                    'ofLast2Weeks' => __('filament-date-scopes-filter::date-scope.Weeks.ofLast2Weeks'),
                    'ofLast3Weeks' => __('filament-date-scopes-filter::date-scope.Weeks.ofLast3Weeks'),
                    'ofLast4Weeks' => __('filament-date-scopes-filter::date-scope.Weeks.ofLast4Weeks'),
                    'ofLastWeeks' => __('filament-date-scopes-filter::date-scope.Weeks.ofLastWeeks'),
                ],
            ],
            'month' => [
                'label' => __('filament-date-scopes-filter::date-scope.Months.label'),
                'scopes' => [
                    'ofLastMonth' => __('filament-date-scopes-filter::date-scope.Months.ofLastMonth'),
                    'ofLast3Months' => __('filament-date-scopes-filter::date-scope.Months.ofLast3Months'),
                    'ofLast6Months' => __('filament-date-scopes-filter::date-scope.Months.ofLast6Months'),
                    'ofLast9Months' => __('filament-date-scopes-filter::date-scope.Months.ofLast9Months'),
                    'ofLast12Months' => __('filament-date-scopes-filter::date-scope.Months.ofLast12Months'),
                    'ofLastMonths' => __('filament-date-scopes-filter::date-scope.Months.ofLastMonths'),
                ],
            ],
            'quarter' => [
                'label' => __('filament-date-scopes-filter::date-scope.Quarters.label'),
                'scopes' => [
                    'ofLastQuarter' => __('filament-date-scopes-filter::date-scope.Quarters.ofLastQuarter'),
                    'ofLast2Quarters' => __('filament-date-scopes-filter::date-scope.Quarters.ofLast2Quarters'),
                    'ofLast3Quarters' => __('filament-date-scopes-filter::date-scope.Quarters.ofLast3Quarters'),
                    'ofLast4Quarters' => __('filament-date-scopes-filter::date-scope.Quarters.ofLast4Quarters'),
                    'ofLastQuarters' => __('filament-date-scopes-filter::date-scope.Quarters.ofLastQuarters'),
                ],
            ],
            'year' => [
                'label' => __('filament-date-scopes-filter::date-scope.Years.label'),
                'scopes' => [
                    'ofLastYear' => __('filament-date-scopes-filter::date-scope.Years.ofLastYear'),
                    'ofLastYears' => __('filament-date-scopes-filter::date-scope.Years.ofLastYears'),
                ],
            ],
            'decade' => [
                'label' => __('filament-date-scopes-filter::date-scope.Decades.label'),
                'scopes' => [
                    'ofLastDecade' => __('filament-date-scopes-filter::date-scope.Decades.ofLastDecade'),
                    'ofLastDecades' => __('filament-date-scopes-filter::date-scope.Decades.ofLastDecades'),
                ],
            ],
            'century' => [
                'label' => __('filament-date-scopes-filter::date-scope.Centuries.label'),
                'scopes' => [
                    'ofLastCentury' => __('filament-date-scopes-filter::date-scope.Centuries.ofLastCentury'),
                    'ofLastCenturies' => __('filament-date-scopes-filter::date-scope.Centuries.ofLastCenturies'),
                ],
            ],
            'millennium' => [
                'label' => __('filament-date-scopes-filter::date-scope.Millenniums.label'),
                'scopes' => [
                    'ofLastMillennium' => __('filament-date-scopes-filter::date-scope.Millenniums.ofLastMillennium'),
                    'ofLastMillenniums' => __('filament-date-scopes-filter::date-scope.Millenniums.ofLastMillenniums'),
                ],
            ],
            'to_now' => [
                'label' => __('filament-date-scopes-filter::date-scope.toNow/toDate.label'),
                'scopes' => [
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
            ],
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

                    return __('filament-date-scopes-filter::date-scope.Include last').' '.__('filament-date-scopes-filter::date-scope.'.$lastWord.'.label');
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
