<?php

include_once dirname(__FILE__) . '/' . '../utils/system_utils.php';
// require_once 'components/utils/system_utils.php';

function GetOrderTypeCaption($orderType)
{
    global $orderTypeCaptions;
    return $orderTypeCaptions[$orderType];
}

include(dirname(__FILE__) . '/columns/column_visibility.php');
include(dirname(__FILE__) . '/columns/custom_view_column.php');
include(dirname(__FILE__) . '/columns/custom_dataset_field_view_column.php');
include(dirname(__FILE__) . '/columns/text_view_column.php');
include(dirname(__FILE__) . '/columns/date_time_view_column.php');
include(dirname(__FILE__) . '/columns/custom_format_value_view_column_decorator.php');
include(dirname(__FILE__) . '/columns/div_tag_view_column_decorator.php');
include(dirname(__FILE__) . '/columns/check_box_format_value_view_column_decorator.php');
include(dirname(__FILE__) . '/columns/number_format_value_view_column_decorator.php');
include(dirname(__FILE__) . '/columns/currency_format_value_view_column_decorator.php');
include(dirname(__FILE__) . '/columns/string_format_value_view_column_decorator.php');
include(dirname(__FILE__) . '/columns/percent_format_value_view_column_decorator.php');
include(dirname(__FILE__) . '/columns/extended_hyper_link_column_decorator.php');
include(dirname(__FILE__) . '/columns/download_data_column.php');
include(dirname(__FILE__) . '/columns/download_external_data_column.php');
include(dirname(__FILE__) . '/columns/external_image_column.php');
include(dirname(__FILE__) . '/columns/external_audio_file_column.php');
include(dirname(__FILE__) . '/columns/image_view_column.php');
include(dirname(__FILE__) . '/columns/detail_column.php');

?>