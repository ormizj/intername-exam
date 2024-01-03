<?php

require_once __DIR__ . '/../repository/leads.php';
require_once __DIR__ . '/../utils/header.php';
require_once __DIR__ . '/../utils/request.php';
require_once __DIR__ . '/../models/leads.php';

function create_lead($leadData)
{
    $lead = new Lead($leadData);

    if (!$lead->isValid()) {
        header_422();
        return gen_error(422, 'LDS-002');
    }

    $leadByEmail = db_get_lead_email($lead->email);
    if (isset($leadByEmail)) {
        header_422();
        return gen_error(422, 'LDS-003');
    }

    try {
        $leadId = db_create_lead($lead);
        header_200();
        return gen_success(200, $leadId);

    } catch (Exception $e) {
        print_r($e);
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
        print_r($e);
        header_500();
        return gen_error(500, 'INT-001');
    }
}

function get_all_leads()
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

function get_lead_by_id($id)
{
    try {
        $lead = db_get_lead_by_id($id);

    } catch (Exception $e) {
        print_r($e);
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
        print_r($e);
        header_500();
        return gen_error(500, 'INT-001');
    }
}
