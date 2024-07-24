<?php 

// Get WooCommerce countries and states
global $woocommerce;
$countries_obj = new WC_Countries();
$countries = $countries_obj->__get('countries');
$states = $countries_obj->__get('states');

// Function to save countries to CSV
function save_countries_to_csv($countries)
{
    $csv_file_path = get_template_directory() . '/json-data/countries.csv';
    $file = fopen($csv_file_path, 'w');
    fputcsv($file, ['Code', 'Country', 'Code', 'Country', 'Code', 'Country']);

    $country_rows = array_chunk($countries, 3, true);
    foreach ($country_rows as $row) {
        $csv_row = [];
        foreach ($row as $code => $name) {
            $csv_row[] = $code;
            $csv_row[] = $name;
        }
        fputcsv($file, $csv_row);
    }

    fclose($file);
    echo "Countries CSV file has been created successfully.\n";
}

// Function to save states to CSV
function save_states_to_csv($countries, $states)
{
    $csv_file_path = get_template_directory() . '/json-data/states.csv';
    $file = fopen($csv_file_path, 'w');

    foreach ($countries as $country_code => $country_name) {
        if (isset($states[$country_code]) && is_array($states[$country_code])) {
            // Write the header for each country
            fputcsv($file, ['Code', 'State', 'Code', 'State', 'Code', 'State']);

            $state_rows = array_chunk($states[$country_code], 3, true);
            foreach ($state_rows as $row) {
                $csv_row = [];
                foreach ($row as $code => $name) {
                    $csv_row[] = $code;
                    $csv_row[] = $name;
                }
                fputcsv($file, $csv_row);
            }
            fputcsv($file, []); // Empty row after each country's states
        }
    }

    fclose($file);
    echo "States CSV file has been created successfully.\n";
}

// Save countries and states to CSV
save_countries_to_csv($countries);
save_states_to_csv($countries, $states);
