<?php
set_include_path('../..' . PATH_SEPARATOR . get_include_path());
include_once 'components/captions.php';

header('Content-Type: application/javascript');

$captions = GetCaptions('UTF-8');

/**
 * @param Captions $captions
 * @param string $code
 * @internal param string $value
 * @param bool $suppressComma
 * @return void
 */
function BuildLocalizationString($captions, $code, $suppressComma = false)
{
    echo sprintf('"%s": "%s"', $code, $captions->GetMessageString($code));
    if (!$suppressComma)
        echo ',';
}

?>
define(function(require, exports) {

exports.resource = {<?php

BuildLocalizationString($captions, 'DeleteUserConfirmation');

BuildLocalizationString($captions, 'And');
BuildLocalizationString($captions, 'Ok');

BuildLocalizationString($captions, 'CalendarMonths');
BuildLocalizationString($captions, 'CalendarMonthsShort');
BuildLocalizationString($captions, 'CalendarWeekdays');
BuildLocalizationString($captions, 'CalendarWeekdaysShort');
BuildLocalizationString($captions, 'CalendarWeekdaysMin');

BuildLocalizationString($captions, 'Cancel');
BuildLocalizationString($captions, 'Commit');
BuildLocalizationString($captions, 'ErrorsDuringUpdateProcess');
BuildLocalizationString($captions, 'PasswordChanged');

BuildLocalizationString($captions, 'Equals');
BuildLocalizationString($captions, 'DoesNotEquals');
BuildLocalizationString($captions, 'IsLessThan');
BuildLocalizationString($captions, 'IsLessThanOrEqualsTo');
BuildLocalizationString($captions, 'IsGreaterThan');
BuildLocalizationString($captions, 'IsGreaterThanOrEqualsTo');
BuildLocalizationString($captions, 'Like');
BuildLocalizationString($captions, 'IsBlank');
BuildLocalizationString($captions, 'IsNotBlank');
BuildLocalizationString($captions, 'IsLike');
BuildLocalizationString($captions, 'IsNotLike');

BuildLocalizationString($captions, 'Contains');
BuildLocalizationString($captions, 'DoesNotContain');
BuildLocalizationString($captions, 'BeginsWith');
BuildLocalizationString($captions, 'EndsWith');

BuildLocalizationString($captions, 'OperatorAnd');
BuildLocalizationString($captions, 'OperatorOr');
BuildLocalizationString($captions, 'OperatorNone');

BuildLocalizationString($captions, 'Loading');
BuildLocalizationString($captions, 'FilterBuilder');
BuildLocalizationString($captions, 'DeleteSelectedRecordsQuestion');

BuildLocalizationString($captions, 'DeleteRecordQuestion');

BuildLocalizationString($captions, 'FilterOperatorEquals');
BuildLocalizationString($captions, 'FilterOperatorDoesNotEqual');
BuildLocalizationString($captions, 'FilterOperatorIsGreaterThan');
BuildLocalizationString($captions, 'FilterOperatorIsGreaterThanOrEqualTo');
BuildLocalizationString($captions, 'FilterOperatorIsLessThan');
BuildLocalizationString($captions, 'FilterOperatorIsLessThanOrEqualTo');
BuildLocalizationString($captions, 'FilterOperatorIsBetween');
BuildLocalizationString($captions, 'FilterOperatorIsNotBetween');
BuildLocalizationString($captions, 'FilterOperatorContains');
BuildLocalizationString($captions, 'FilterOperatorDoesNotContain');
BuildLocalizationString($captions, 'FilterOperatorBeginsWith');
BuildLocalizationString($captions, 'FilterOperatorEndsWith');
BuildLocalizationString($captions, 'FilterOperatorIsLike');
BuildLocalizationString($captions, 'FilterOperatorIsNotLike');
BuildLocalizationString($captions, 'FilterOperatorIsBlank');
BuildLocalizationString($captions, 'FilterOperatorIsNotBlank');

BuildLocalizationString($captions, 'Select2MatchesOne');
BuildLocalizationString($captions, 'Select2MatchesMoreOne');
BuildLocalizationString($captions, 'Select2NoMatches');
BuildLocalizationString($captions, 'Select2AjaxError');
BuildLocalizationString($captions, 'Select2InputTooShort');
BuildLocalizationString($captions, 'Select2InputTooLong');
BuildLocalizationString($captions, 'Select2SelectionTooBig');
BuildLocalizationString($captions, 'Select2LoadMore');
BuildLocalizationString($captions, 'Select2Searching');

BuildLocalizationString($captions, 'SaveAndInsert');
BuildLocalizationString($captions, 'SaveAndBackToList');
BuildLocalizationString($captions, 'SaveAndEdit');
BuildLocalizationString($captions, 'Save');


BuildLocalizationString($captions, 'MultipleColumnSorting');
BuildLocalizationString($captions, 'Column');
BuildLocalizationString($captions, 'Order');
BuildLocalizationString($captions, 'Sort');
BuildLocalizationString($captions, 'AddLevel');
BuildLocalizationString($captions, 'DeleteLevel');
BuildLocalizationString($captions, 'Ascending');
BuildLocalizationString($captions, 'SortBy');
BuildLocalizationString($captions, 'ThenBy');
BuildLocalizationString($captions, 'Descending', true);


?>};

});