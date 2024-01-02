<?php

require_once __DIR__ . '/../router/leads.php';
require_once __DIR__ . '/../utils/header.php';
require_once __DIR__ . '/../utils/string.php';
require_once __DIR__ . '/../utils/request.php';

function create_lead($lead)
{
    $validations = ['firstName', 'lastName', 'email', 'phoneNumber', 'ip', 'country', 'url', 'sub1'];

    foreach ($validations as $validation) {
        if (is_string_empty($lead[$validation])) {
            header_422();
            return gen_error(422, 'LDS-002');
        }
    }

    $leadByEmail = db_get_lead_email($lead['email']);
    if (isset($leadByEmail)) {
        header_422();
        return gen_error(422, 'LDS-003');
    }

    try {
        $leadId = db_create_lead($lead);
        header_200();
        return gen_success(200, $leadId);

    } catch (Exception $e) {
        header_500();
        return gen_error(500, 'INT-001');
    }
}

function mark_lead_as_called($id)
{
    $lead = db_get_lead_by_id($id);

    if (!isset($lead)) {
        header_404();
        return gen_error(404, 'LDS-001');
    }

    if ($lead['called']) {
        header_409();
        return gen_error(409, 'LDS-004');
    }

    try {
        $result = db_mark_lead_as_called($id);
        header_200();
        return gen_success(200, $result);

    } catch (Exception $e) {
        header_500();
        return gen_error(500, 'INT-001');
    }
}

function get_lead_by_id($id)
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

function get_leads_by_filter($filters)
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
