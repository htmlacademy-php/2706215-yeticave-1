<?php

declare(strict_types=1);

/**
 * Validates required form fields and returns validation errors.
 *
 * @param string[] $required_fields
 * @param array $form_data
 * @param array $form_errors
 * @return array
 */
function validate_form_data(array $required_fields = [], array $form_data = [], array $form_errors = []): array
{
    foreach ($required_fields as $field) {
        if (empty($form_data[$field])) {
            $form_errors[$field] = 'Заполните это поле';
        } elseif ($field === 'expire_date' && !is_date_valid($form_data[$field])) {
            $form_errors[$field] = 'Некорректная дата';
        } else {
            unset($form_errors[$field]);
        }
    }

    return $form_errors;
}
