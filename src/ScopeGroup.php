<?php

namespace AymanAlhattami\FilamentDateScopesFilter;

enum ScopeGroup: string
{
    case Seconds = 'seconds';
    case Minutes = 'minutes';
    case Hours = 'hours';
    case Days = 'days';
    case Weeks = 'weeks';
    case Months = 'months';
    case Quarters = 'quarters';
    case Years = 'years';
    case Decades = 'decades';
    case Centuries = 'centuries';
    case Millenniums = 'millenniums';
    case Custom = 'custom';
}
