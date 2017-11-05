<?php
/*
Instructions:

- To contribute a localization file populate the variables below with standards of your language + country
- For HTML inputs, only edit the value= attribute, but not if the value contains a [placeholder]
- Don't edit [placeholders]
- Name the file in the following format: 2letterlanguage-2lettercountry.php, for example en-us.php

country codes: https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
language codes: https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes

Thanks for your help!
-Ian
*/

// javascript dialogs
$this->delete_confirm      = 'Sind Sie sicher, dass Sie diesen Eintrag löschen möchten?';
$this->update_grid_confirm = 'Sind Sie sicher, dass Sie diese [count] Einträge löschen möchten?';

// form buttons
$this->form_add_button_text    = "Hinzufügen";
$this->form_update_button_text = "Aktualisieren";
$this->form_duplicate_button_text = "Kopieren";

// titles in the <th> of top of the edit form 
$this->form_text_title_add    = 'Eintrag hinzufügen';   
$this->form_text_title_edit   = 'Eintrag bearbeiten';
$this->form_text_record_saved = 'Eintrag gespeichert';
$this->form_text_record_added = 'Eintrag hinzugefügt';

// links on grid
$this->grid_add_link_text    = "Neuer Eintrag";
$this->grid_edit_link_text   = "ändern";
$this->grid_export_link_text = "CSV herunterladen";

// search box
// $this->grid_search_box = "
  // <form action='[script_name]' class='lm_search_box'>
    // [filters]
    // <input type='text' name='_search' value='[_search]' size='20' class='lm_search_input'>
    // <a href='[script_name]' title='[grid_search_box_clear]' class='button_clear_search'>x</a>
    // <input type='submit' class='lm_button lm_search_button' value='[grid_search_box_search]'>
    // <input type='hidden' name='action' value='search'>[query_string_list]
  // </form>"; 


// grid messages
$this->grid_text_record_added     = "Eintrag hinzugefügt";
$this->grid_text_changes_saved    = "Änderungen gespeichert";
$this->grid_text_record_deleted   = "Eintrag gelöscht";
$this->grid_text_save_changes     = "Änderungen speichern";
$this->grid_text_delete           = "Löschen";
$this->grid_text_no_records_found = "Keine Einträge gefunden";

// pagination text
$this->pagination_text_use_paging = 'use paging';
$this->pagination_text_show_all   = 'alle anzeigen';
$this->pagination_text_records    = 'Einträge'; // singular: "Eintrag", looks better than "Eintrag/Einträge"
$this->pagination_text_go         = 'aufrufen'; // not the best translation, but no better idea
$this->pagination_text_page       = 'Seite';
$this->pagination_text_of         = 'von';
$this->pagination_text_next       = 'Nächste&gt;';
$this->pagination_text_back       = '&lt;Vorherige';

// delete upload link text
$this->text_delete_image = 'Bild löschen';
$this->text_delete_document = 'Dokument löschen';

// relative paths for --image or --document uploads
// paths are created at runtime as needed
$this->upload_path = 'uploads';            // required when using  input types
$this->thumb_path = 'thumbs';              // optional, leave blank if you don't need thumbnails

// output date formats
$this->date_out = 'd.m.Y';
$this->datetime_out = 'd.m.Y, H:i';


/******************************************************************************/
/*                        eEKS specific translation                           */

// language for html lang attribute
$this->html_lang = "de";

// form delete button text = grid_text_delete
$this->form_back_button_text   = "Zurück";
$this->grid_search_box_clear = "Suche zurücksetzen";
$this->grid_search_box_search = "Suche";

// placeholders for date filters
$this->date_filter_from = "von";
$this->date_filter_to = "bis";

// other words that need translation and may appear somewhere
$this->translate['all'] = "alle";
$this->translate['income'] = "Einkommen";
$this->translate['costs'] = "Ausgaben";
$this->translate['settings'] = "Einstellungen";
$this->translate['monthly'] = "monatlich";

// number format
$this->decimals = 2;
$this->dec_point = ',';
$this->thousands_sep = '.';

// rename multi-value column
$this->multi_value_column_title = "Mehrere Einträge";

// rename fieldnames from database

$this->rename['date_created'] = 'Erstellt am';
$this->rename['date_last_changed'] = 'zuletzt geändert';
$this->rename['value_date'] = 'Zahlungs-Datum';
$this->rename['voucher_date'] = 'Beleg-Datum';
$this->rename['gross_amount'] = 'Bruttobetrag';
$this->rename['tax_rate'] = 'Steuersatz';
$this->rename['account'] = 'Konto';
$this->rename['invoice_number'] = 'Rechnungs-Nr.';
$this->rename['from_to'] = 'Auftraggeber/ Empfänger';
$this->rename['posting_text'] = 'Buchungstext';
$this->rename['object'] = 'Gegenstand';
$this->rename['type_of_costs'] = 'Kostenart/ Erlösart';
$this->rename['mode_of_employment'] = 'Beschäftigungsart';
$this->rename['cat_01'] = 'Geschäftsbereich';
$this->rename['cat_02'] = 'Projekt';
$this->rename['cat_03'] = 'Fördermittelgeber_in';
$this->rename['cat_04'] = 'Kategorie 4';
$this->rename['cat_05'] = 'Kategorie 5';
// $this->rename['cat_06'] = 'Kategorie 6';
// $this->rename['cat_07'] = 'Kategorie 7';
// $this->rename['cat_08'] = 'Kategorie 8';
// $this->rename['cat_09'] = 'Kategorie 9';
// $this->rename['cat_10'] = 'Kategorie 10';
$this->rename['notes_01'] = 'Notizen';
$this->rename['notes_02'] = 'Garantie';
$this->rename['notes_03'] = 'Notiz 3';
$this->rename['notes_04'] = 'Notiz 4';
$this->rename['notes_05'] = 'Notiz 5';
$this->rename['file_01'] = 'Beleg';
$this->rename['file_02'] = 'Datei 2';
$this->rename['file_03'] = 'Datei 3';


// rename fields from other tables
$this->rename['is_income'] = 'ist Einnahme';
$this->rename['sort_order'] = 'Sortierreihenfolge';
$this->rename['notes'] = 'Notizen';

$this->rename['sum'] = 'Summe';
$this->rename['average'] = 'Ø';

$this->rename['topic'] = 'Oberthema';
$this->rename['page'] = 'Seite';
$this->rename['coa_jobcenter_eks_01_2017'] = 'Kontenrahmen Jobcenter-EKS.01.2017';
