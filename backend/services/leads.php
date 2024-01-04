<?php

require_once __DIR__ . '/../repository/leads.php';
require_once __DIR__ . '/../utils/header.php';
require_once __DIR__ . '/../utils/request.php';
require_once __DIR__ . '/../models/leads.php';

/**
 * @param $leadData array containing data with all the required valid values to create a new {Lead}
 * @return array of a resolved request
 */
function create_lead(array $leadData): array
{
    $lead = new Lead($leadData);

    if (!$lead->isValid()) {
        header_422();
        return gen_error(422, 'LDS-002');
    }

    try {
        $leadByEmail = db_get_lead_email($lead->email);
        if (isset($leadByEmail)) {
            header_422();
            return gen_error(422, 'LDS-003');
        }

        $leadId = db_create_lead($lead);
        header_200();
        return gen_success(200, $leadId);

    } catch (Exception $e) {
        header_500();
        return gen_error(500, 'INT-001');
    }
}

/**
 * @param $id int of a Lead (prefer existing {Lead})
 * @return array of a resolved request
 */
function mark_lead_as_called(int $id): array
{
    try {
        $lead = db_get_lead_by_id($id);

        if (!isset($lead)) {
            header_404();
            return gen_error(404, 'LDS-001');
        }

        if ($lead['called']) {
            header_409();
            return gen_error(409, 'LDS-004');
        }

        $result = db_mark_lead_as_called($id);
        header_200();
        return gen_success(200, $result);

    } catch (Exception $e) {
        header_500();
        return gen_error(500, 'INT-001');
    }
}

/**
 * @return array of a resolved request
 */
function get_all_leads(): array
{
    try {
        $leads = db_get_all_leads();
        header_200();
        return gen_success(200, $leads);

    } catch (Exception $e) {
        header_500();
        return gen_error(500, 'INT-001');
    }
}

/**
 * @param $id int of a Lead (prefer existing {Lead})
 * @return array of a resolved request
 */
function get_lead_by_id(int $id): array
{
    try {
        $lead = db_get_lead_by_id($id);

    } catch (Exception $e) {
        header_500();
        return gen_error(500, 'INT-001');
    }

    if (!isset($lead)) {
        header_404();
        return gen_error(404, 'LDS-001');
    }

    header_200();
    return gen_success(200, $lead);
}

/**
 * @param $filters array {isCalled string = null, isCreatedToday string = null, country string = null} criteria to filter
 * @return array
 */
function get_leads_by_filter(array $filters): array
{
    $availableFilters = ['isCalled', 'isCreatedToday', 'country'];
    $noFilterSelected = true;

    foreach ($availableFilters as $availableFilter) {
        if (isset($filters[$availableFilter])) {
            $noFilterSelected = false;
            break;
        }
    }

    if ($noFilterSelected) {
        header_422();
        return gen_error(422, 'LDS-005');
    }

    try {
        $leadId = db_get_leads_by_filter($filters);
        header_200();
        return gen_success(200, $leadId);

    } catch (Exception $e) {
        header_500();
        return gen_error(500, 'INT-001');
    }
}
