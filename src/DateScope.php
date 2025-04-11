<?php

namespace AymanAlhattami\FilamentDateScopesFilter;

enum DateScope: string
{
    case OfJustNow = 'ofJustNow';
    case OfLastSecond = 'ofLastSecond';
    case OfLast15Seconds = 'ofLast15Seconds';
    case OfLast30Seconds = 'ofLast30Seconds';
    case OfLast45Seconds = 'ofLast45Seconds';
    case OfLast60Seconds = 'ofLast60Seconds';
    case OfLastSeconds = 'ofLastSeconds';


    case MinuteToNow = 'minuteToNow';
    case OfLastMinute = 'ofLastMinute';
    case OfLast15Minutes = 'ofLast15Minutes';
    case OfLast30Minutes = 'ofLast30Minutes';
    case OfLast45Minutes = 'ofLast45Minutes';
    case OfLast60Minutes = 'ofLast60Minutes';
    case OfLastMinutes = 'ofLastMinutes';


    case HourToNow = 'hourToNow';
    case OfLastHour = 'ofLastHour';
    case OfLast6Hours = 'ofLast6Hours';
    case OfLast12Hours = 'ofLast12Hours';
    case OfLast18Hours = 'ofLast18Hours';
    case OfLast24Hours = 'ofLast24Hours';
    case OfLastHours = 'ofLastHours';


    case DayToNow = 'dayToNow';
    case OfToday = 'ofToday';
    case OfYesterday = 'ofYesterday';
    case OfLast7Days = 'ofLast7Days';
    case OfLast21Days = 'ofLast21Days';
    case OfLast30Days = 'ofLast30Days';
    case OfLastDays = 'ofLastDays';


    case WeekToDate = 'weekToDate';
    case OfLastWeek = 'ofLastWeek';
    case OfLast2Weeks = 'ofLast2Weeks';
    case OfLast3Weeks = 'ofLast3Weeks';
    case OfLast4Weeks = 'ofLast4Weeks';
    case OfLastWeeks = 'ofLastWeeks';


    case MonthToDate = 'monthToDate';
    case OfLastMonth = 'ofLastMonth';
    case OfLast3Months = 'ofLast3Months';
    case OfLast6Months = 'ofLast6Months';
    case OfLast9Months = 'ofLast9Months';
    case OfLast12Months = 'ofLast12Months';
    case OfLastMonths = 'ofLastMonths';


    case QuarterToDate = 'quarterToDate';
    case OfLastQuarter = 'ofLastQuarter';
    case OfLast2Quarters = 'ofLast2Quarters';
    case OfLast3Quarters = 'ofLast3Quarters';
    case OfLast4Quarters = 'ofLast4Quarters';
    case OfLastQuarters = 'ofLastQuarters';


    case YearToDate = 'yearToDate';
    case OfLastYear = 'ofLastYear';
    case OfLastYears = 'ofLastYears';


    case DecadeToDate = 'decadeToDate';
    case OfLastDecade = 'ofLastDecade';
    case OfLastDecades = 'ofLastDecades';


    case CenturyToDate = 'centuryToDate';
    case OfLastCentury = 'ofLastCentury';
    case OfLastCenturies = 'ofLastCenturies';


    case MillenniumToDate = 'millenniumToDate';
    case OfLastMillennium = 'ofLastMillennium';
    case OfLastMillenniums = 'ofLastMillenniums';


    case Custom = 'custom';
}