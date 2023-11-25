<?php

namespace AymanAlhattami\FilamentDateScopesFilter;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use LaracraftTech\LaravelDateScopes\DateRange;

class DateScopeFilter extends Filter
{
    private array $scopes = [
        'Seconds' => [
            'ofJustNow' => 'Just Now',
            'ofLastSecond' => 'Last Second',
            'ofLast15Seconds' => 'Last 15 Seconds',
            'ofLast30Seconds' => 'Last 30 Seconds',
            'ofLast45Seconds' => 'Last 45 Seconds',
            'ofLast60Seconds' => 'Last 60 Seconds',
            'ofLastSeconds' => 'Last Seconds'
        ],
        'Minutes' => [
            'ofLastMinute' => 'Last Minute',
            'ofLast15Minutes' => 'Last 15 Minutes',
            'ofLast30Minutes' => 'Last 30 Minutes',
            'ofLast45Minutes' => 'Last 45 Minutes',
            'ofLast60Minutes' => 'Last 60 Minutes',
            'ofLastMinutes' => 'Last Minutes',
        ],
        'Hours' => [
            'ofLastHour' => 'Last Hour',
            'ofLast6Hours' => 'Last 6 Hours',
            'ofLast12Hours' => 'Last 12 Hours',
            'ofLast18Hours' => 'Last 18 Hours',
            'ofLast24Hours' => 'Last 24 Hours',
            'ofLastHours' => 'Last Hours',
        ],
        'Days' => [
            'ofToday' => 'Today',
            'ofYesterday' => 'Yesterday',
            'ofLast7Days' => 'Last 7D ays',
            'ofLast21Days' => 'Last 21 Days',
            'ofLast30Days' => 'Last 30 Days',
            'ofLastDays' => 'Last Days',
        ],
        'Weeks' => [
            'ofLastWeek' => 'Last Week',
            'ofLast2Weeks' => 'Last 2 Weeks',
            'ofLast3Weeks' => 'Last 3 Weeks',
            'ofLast4Weeks' => 'Last 4 Weeks',
            'ofLastWeeks' => 'Last Weeks',
        ],
        'Months' => [
            'ofLastMonth' => 'Last Month',
            'ofLast3Months' => 'Last 3 Months',
            'ofLast6Months' => 'Last 6 Months',
            'ofLast9Months' => 'Last 9 Months',
            'ofLast12Months' => 'Last 12 Months',
            'ofLastMonths' => 'Last Months',
        ],
        'Quarters' => [
            'ofLastQuarter' => 'Last Quarter',
            'ofLast2Quarters' => 'Last 2 Quarters',
            'ofLast3Quarters' => 'Last 3 Quarters',
            'ofLast4Quarters' => 'Last 4 Quarters',
            'ofLastQuarters' => 'Last Quarters'
        ],
        'Years' => [
            'ofLastYear' => 'Last Year',
            'ofLastYears' => 'Last Years'
        ],
        'Decades' => [
            'ofLastDecade' => 'Last Decade',
            'ofLastDecades' => 'Last Decades'
        ],
        'Centuries' => [
            'ofLastCentury' => 'Last Century',
            'ofLastCenturies' => 'Last Centuries'
        ],
        'Millenniums' => [
            'ofLastMillennium' => 'Last Millennium',
            'ofLastMillenniums' => 'Last Millenniums'
        ],
        'toNow/toDate' => [
            'secondToNow' => 'Second To Now',
            'minuteToNow' => 'Minute To Now',
            'hourToNow' => 'Hour To Now',
            'dayToNow' => 'Day To Now',
            'weekToDate' => 'Week To Date',
            'monthToDate' => 'Month To Date',
            'quarterToDate' => 'Quarter To Date',
            'yearToDate' => 'Year To Date',
            'decadeToDate' => 'Decade To Date',
            'centuryToDate' => 'Century To Date',
            'millenniumToDate' => 'Millennium To Date'
        ]
    ];

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
        'ofLastMillenniums'
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

        $this->form(fn() => [
            Grid::make($this->getColumns())->schema([
                Select::make($this->getName())
                    ->options($this->scopes)
                    ->searchable()
                    ->reactive(),
                TextInput::make('additional_parameter')
                    ->label(function (Get $get) {
                        $words = preg_split('/(?=[A-Z])/', $get($this->getName()), -1, PREG_SPLIT_NO_EMPTY);
                        $lastWord = end($words);

                        return __('Number of ' . $lastWord);
                    })
                    ->default(2)
                    ->numeric()
                    ->visible(function (Get $get) {
                        return (bool)in_array($get($this->getName()), $this->scopesRequireAdditionalParameters);
                    }),
                Select::make('range')
                    ->options(function(){
                        return collect(DateRange::cases())->mapWithKeys(function ($dateRange) {
                            return [$dateRange->value => $dateRange->name];
                        })->toArray();
                    })
                    ->searchable()
                    ->visible(function(Get $get){
                        return (bool)(!is_null($get($this->getName())) && !in_array($get($this->getName()), $this->scopesDontSupportRange));
                    })
                    ->default(DateRange::EXCLUSIVE->value)
            ]),
        ])->query(function (Builder $query, array $data) {
            return $query->when($data[$this->getName()] ?? null, function ($query, $value) use ($data) {
                if (in_array($value, $this->scopesRequireAdditionalParameters)) {
                    $parameterValue = (!is_null($data['additional_parameter']) && intval($data['additional_parameter']) >= 1)
                        ? $data['additional_parameter']
                        : 1;
                    if (!in_array($data[$this->getName()], $this->scopesDontSupportRange)) {
                        return $query->{$value}(intval($parameterValue), customRange: DateRange::tryFrom($data['range']));
                    } else {
                        return $query->{$value}(intval($parameterValue));
                    }
                }

                if (!in_array($data[$this->getName()], $this->scopesDontSupportRange)) {
                    return $query->{$value}(customRange: DateRange::tryFrom($data['range']));
                } else {
                    return $query->{$value}();
                }
            });
        });
    }
}

