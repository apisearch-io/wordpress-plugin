<?php
/**
 * File header placeholder
 */

$apisearchSearchableDisabled = get_post_meta($object->ID, "apisearch_searchable_disabled", true);

?>

<?php wp_nonce_field(basename(__FILE__), "apisearch_metabox_nonce"); ?>
<div>
    <input name="apisearch-searchable-disabled" type="checkbox" value="true"<?php if($apisearchSearchableDisabled) echo ' checked'; ?>>
    <label for="apisearch-searchable-disabled">Exclude from search</label>
</div>