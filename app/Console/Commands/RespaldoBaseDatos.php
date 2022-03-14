<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpZip\ZipFile;
use DB;
use Storage;

class RespaldoBaseDatos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Respaldo base de datos y carpeta storage';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $get_all_table_query = "SHOW TABLES";
        $result = DB::select(DB::raw($get_all_table_query));

        $tables = collect();

        $all_tables = DB::select('SHOW TABLES'); // returns an array of stdObjects

        foreach($all_tables as $table)
        {
            $tables->add($table->Tables_in_tutiendafacil);
        }

        $structure = '';
        $data = '';
        foreach ($tables as $table) {
            $show_table_query = "SHOW CREATE TABLE " . $table . "";

            $show_table_result = DB::select(DB::raw($show_table_query));

            foreach ($show_table_result as $show_table_row) {
                $show_table_row = (array)$show_table_row;
                $structure .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
            }
            $select_query = "SELECT * FROM " . $table;
            $records = DB::select(DB::raw($select_query));

            foreach ($records as $record) {
                $record = (array)$record;
                $table_column_array = array_keys($record);
                foreach ($table_column_array as $key => $name) {
                    $table_column_array[$key] = '`' . $table_column_array[$key] . '`';
                }

                $table_value_array = array_values($record);
                $data .= "\nINSERT INTO $table (";

                $data .= "" . implode(", ", $table_column_array) . ") VALUES \n";

                foreach($table_value_array as $key => $record_column)
                    $table_value_array[$key] = addslashes($record_column);

                $data .= "('" . implode("','", $table_value_array) . "');\n";
            }
        }
        
        $db_name        = 'database_'.date('d_m_Y_H_i').'.sql';
        $file_handle    = fopen(storage_path('backups/' . $db_name), 'w + ');

        $output = $structure . $data;
        fwrite($file_handle, $output);
        fclose($file_handle);
        
        $zip            = new ZipFile();
        $storage_name   = 'storage_'.date('d_m_Y_H_i').'.zip';
        
        $zip
            ->addDirRecursive(storage_path('app/public'))
            ->saveAsFile(storage_path("backups/".$storage_name))
            ->close(); 


        if (!extension_loaded('ftp')) {
            echo 'FTP extension is not loaded!';
        }

        Storage::disk('ftp')->put($storage_name, fopen(storage_path("backups/".$storage_name), 'r+'));
        Storage::disk('ftp')->put($db_name, fopen(storage_path("backups/".$db_name), 'r+'));

        $data = [];
        email('email.respaldo', "Respaldo de base de datos", $data, 'admin@tutiendafacil.uy');

        unlink(storage_path("backups/".$storage_name));
        unlink(storage_path("backups/".$db_name));

        $this->info("Se realiza el respaldo de la base de datos");
    }
}
