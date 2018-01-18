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

// grid messages
$this->grid_text_record_added     = "Eintrag hinzugefügt";
$this->grid_text_changes_saved    = "Änderungen gespeichert";
$this->grid_text_record_deleted   = "Eintrag gelöscht";
$this->grid_text_save_changes     = "Änderungen speichern";
$this->grid_text_delete           = "Löschen";
$this->grid_text_no_records_found = "Keine Einträge gefunden";

// pagination text
$this->pagination_text_use_paging = 'benutze Paginierung';
$this->pagination_text_show_all   = 'alle anzeigen';
$this->pagination_text_records    = 'Einträge';
$this->pagination_text_record     = 'Eintrag';
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
$this->translate['edit'] = "bearbeiten";
$this->translate['income'] = "Einnahmen";
$this->translate['costs'] = "Ausgaben";
$this->translate['settings'] = "Einstellungen";
$this->translate['monthly'] = "monatlich";
$this->translate['monthly_sums'] = "monatlich summiert";
$this->translate['yearly_sums'] = "jährlich summiert";
$this->translate['missing_date'] = "ohne Datum";
$this->translate['edit_tables'] = "Tabellen bearbeiten";
$this->translate['hide'] = "ausblenden";
$this->translate['show'] = "einblenden";
$this->translate['value_date'] = 'Zahlungsdatum';
$this->translate['voucher_date'] = 'Belegdatum';
$this->translate['sum'] = 'Summe';
$this->translate['accounting'] = 'Buchhaltung';
$this->translate['concluded'] = 'abschließend';
$this->translate['estimated'] = 'vorläufig';
$this->translate['eks'] = 'EKS';
$this->translate['cba'] = 'EÜR';
$this->translate['Choose Profile'] = 'Profil auswählen';

// month names (short)
$this->translate['Jan'] = 'Jan';
$this->translate['Feb'] = 'Feb';
$this->translate['Mar'] = 'Mär';
$this->translate['Apr'] = 'Apr';
$this->translate['May'] = 'Mai';
$this->translate['Jun'] = 'Jun';
$this->translate['Jul'] = 'Jul';
$this->translate['Aug'] = 'Aug';
$this->translate['Sep'] = 'Sep';
$this->translate['Oct'] = 'Okt';
$this->translate['Nov'] = 'Nov';
$this->translate['Dec'] = 'Dez';

// number format
$this->decimals = 2;
$this->dec_point = ',';
$this->thousands_sep = '.';

// rename multi-value column
$this->multi_value_column_title = "Mehrere Einträge";

// rename fieldnames from database

// table accounting
$this->rename['date_created'] = 'Erstellt am';
$this->rename['date_last_changed'] = 'zuletzt geändert';
$this->rename['value_date'] = 'Zahlungs-Datum';
$this->rename['voucher_date'] = 'Beleg-Datum';
$this->rename['gross_amount'] = 'Bruttobetrag';
$this->rename['tax_rate'] = 'Steuersatz';
$this->rename['account'] = 'Konto';
$this->rename['invoice_number'] = 'Rechnungs-Nr.';
$this->rename['customer_supplier'] = 'Auftraggeber/ Zulieferer';
$this->rename['posting_text'] = 'Buchungstext';
$this->rename['item'] = 'Gegenstand';
$this->rename['type_of_costs'] = 'Kosten-/Erlösart';
$this->rename['mode_of_employment'] = 'Beschäftigungsart';
$this->rename['scope'] = 'Sparte';
$this->rename['project'] = 'Projekt';
$this->rename['cat_01'] = 'Fördermittelgeber_in';
$this->rename['cat_02'] = 'Kategorie 2';
$this->rename['cat_03'] = 'Kategorie 3';
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
$this->rename['accounting'] = 'Buchhhaltung';

$this->rename['is_income'] = 'ist Einnahme';
$this->rename['sort_order'] = 'Sortierreihenfolge';
$this->rename['notes'] = 'Notizen';

$this->rename['sum'] = 'Summe';
$this->rename['average'] = 'Ø';
$this->rename['old_average'] = 'Ø zuvor';
// $this->rename['average'] = 'Durchschnitt';

$this->rename['topic'] = 'Oberthema';
$this->rename['page'] = 'Seite';
$this->rename['coa_jobcenter_eks_01_2017'] = 'Kontenrahmen Jobcenter-EKS.01.2017';
