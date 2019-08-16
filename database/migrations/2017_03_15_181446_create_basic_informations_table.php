<?php
/**
 * Migration genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Dwij\Laraadmin\Models\Module;

class CreateBasicInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Module::generate("Basic_informations", 'basic_informations', 'nationality', 'fa-angle-double-right', [
            ["photo", "Photo", "File", false, "", 0, 0, false],
            ["blood_group", "Blood Group", "Dropdown", false, "", 0, 0, false, ["O+","O-","A+","A-","B+","B-","AB+","AB-"]],
            ["tel_ofc", "Telephone Office", "TextField", false, "", 0, 256, false],
            ["tel_home", "Telephone Home", "TextField", false, "", 0, 256, false],
            ["cell_ofc", "Cell Office", "TextField", false, "", 0, 256, false],
            ["cell_personal_1", "Cell Personal 1", "Mobile", false, "", 0, 256, false],
            ["cell_personal_2", "Cell Personal 2", "Mobile", false, "", 0, 256, false],
            ["email_ofc", "Email Office", "Email", false, "", 0, 256, false],
            ["email_personal", "Email Personal", "Email", false, "", 0, 256, false],
            ["tribal", "Tribal", "Dropdown", false, "", 0, 0, false, ["Yes","No"]],
            ["freedom_fighter", "Freedom Fighter", "Dropdown", false, "", 0, 0, false, ["Yes","No"]],
            ["emp_id", "RAB ID", "Dropdown", false, "", 0, 0, true, "@employees_info"],
            ["nationality", "Nationality", "TextField", false, "", 0, 256, false],
            ["religion", "Religion", "Dropdown", false, "", 0, 256, false, ["Islam","Christianity","Hinduism","Buddhism","Others"]],
            ["gender", "Gender", "Dropdown", false, "", 0, 0, false, ["Male","Female"]],
            ["marital_status", "Marital Status", "Dropdown", false, "", 0, 0, false, ["Married","Unmarried","Devorced"]],
            ["dob", "Date of Birth", "Date", false, "", 0, 0, false],
            ["birth_place", "Birth Place", "Dropdown", false, "", 0, 0, false, "@districts"],
            ["height", "Height", "TextField", false, "", 0, 256, false],
            ["weight", "Weight", "TextField", false, "", 0, 256, false],
            ["national_id", "National ID", "TextField", false, "", 0, 256, false],
            ["passport_no", "Passport No.", "TextField", false, "", 0, 256, false],
            ["id_card_no", "ID No.", "TextField", false, "", 0, 256, false],
            ["punch_card_no", "Punch Card No.", "TextField", false, "", 0, 256, false],
            ["driving_license", "Driving License", "TextField", false, "", 0, 256, false],
            ["job_join_date", "Joining Date", "Date", false, "", 0, 0, false],
            ["hoby", "hoby", "TextField", false, "", 0, 256, false],
        ]);
		
		/*
		Row Format:
		["field_name_db", "Label", "UI Type", "Unique", "Default_Value", "min_length", "max_length", "Required", "Pop_values"]
        Module::generate("Module_Name", "Table_Name", "view_column_name" "Fields_Array");
        
		Module::generate("Books", 'books', 'name', [
            ["address",     "Address",      "Address",  false, "",          0,  1000,   true],
            ["restricted",  "Restricted",   "Checkbox", false, false,       0,  0,      false],
            ["price",       "Price",        "Currency", false, 0.0,         0,  0,      true],
            ["date_release", "Date of Release", "Date", false, "date('Y-m-d')", 0, 0,   false],
            ["time_started", "Start Time",  "Datetime", false, "date('Y-m-d H:i:s')", 0, 0, false],
            ["weight",      "Weight",       "Decimal",  false, 0.0,         0,  20,     true],
            ["publisher",   "Publisher",    "Dropdown", false, "Marvel",    0,  0,      false, ["Bloomsbury","Marvel","Universal"]],
            ["publisher",   "Publisher",    "Dropdown", false, 3,           0,  0,      false, "@publishers"],
            ["email",       "Email",        "Email",    false, "",          0,  0,      false],
            ["file",        "File",         "File",     false, "",          0,  1,      false],
            ["files",       "Files",        "Files",    false, "",          0,  10,     false],
            ["weight",      "Weight",       "Float",    false, 0.0,         0,  20.00,  true],
            ["biography",   "Biography",    "HTML",     false, "<p>This is description</p>", 0, 0, true],
            ["profile_image", "Profile Image", "Image", false, "img_path.jpg", 0, 250,  false],
            ["pages",       "Pages",        "Integer",  false, 0,           0,  5000,   false],
            ["mobile",      "Mobile",       "Mobile",   false, "+91  8888888888", 0, 20,false],
            ["media_type",  "Media Type",   "Multiselect", false, ["Audiobook"], 0, 0,  false, ["Print","Audiobook","E-book"]],
            ["media_type",  "Media Type",   "Multiselect", false, [2,3],    0,  0,      false, "@media_types"],
            ["name",        "Name",         "Name",     false, "John Doe",  5,  250,    true],
            ["password",    "Password",     "Password", false, "",          6,  250,    true],
            ["status",      "Status",       "Radio",    false, "Published", 0,  0,      false, ["Draft","Published","Unpublished"]],
            ["author",      "Author",       "String",   false, "JRR Tolkien", 0, 250,   true],
            ["genre",       "Genre",        "Taginput", false, ["Fantacy","Adventure"], 0, 0, false],
            ["description", "Description",  "Textarea", false, "",          0,  1000,   false],
            ["short_intro", "Introduction", "TextField",false, "",          5,  250,    true],
            ["website",     "Website",      "URL",      false, "http://dwij.in", 0, 0,  false],
        ]);
		*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('basic_informations')) {
            Schema::drop('basic_informations');
        }
    }
}
