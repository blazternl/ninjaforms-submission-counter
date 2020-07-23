<?php
function blazter_ninjaforms_submission_count ($atts = []) {
    // Set which form to check
	if ($atts['id'] == null) {
        // Default to form 1 if no id attribute is set
		$form_id = 1;
	}
	else {
        // Set the form id by checking the id attribute
		$form_id = $atts['id'];
    }
    
    // Get filters
    if (isset($atts['filters'])) {
        $array = explode(',', $atts['filters']);
        $filters = [];

        foreach ($array as $value) {
            $tempArray = explode('=>', $value);
            $filters[$tempArray[0]] = $tempArray[1];
        }
    }

        
	// Fetch all submissions
	$submissions = Ninja_Forms()->form( $form_id )->get_subs();
    
    // Set submission count to 0
    $submissionCount = 0;

    // Count submissions
    if (count($filters) > 0) {
        foreach($submissions as $submission) {

            // Get submission values
            $values = $submission->get_field_values();

            // Go over each specified filter
            foreach($filter as $filter => $filterValue) {
                // Check if any value besides NULL '*' is the filter
                if ($filterValue == '*') {
                    if (strlen($values[$filter]) > 0) {
                        $submissionCount++;
                    }
                }
                // Check if value is the same as filter value
                else {
                    if ($values[$filter] == $filterValue) {
                        $submissionCount++;
                    }
                }
            }
        }
    }
    else {
        foreach($submissions as $submission) {
            $submissionCount++;
        }
    }

    // Return the amount of valid submissions
    return $submissionCount + $atts['extra'];
}

add_shortcode( 'blazter_ninjaforms_submission_count', 'blazter_ninjaforms_submission_count' );