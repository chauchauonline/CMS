<?php
class Helpers {
    public static  function generateUniqueSlug($title)
    {
        $temp = str_slug($title, '-');
        $count = DB::table('articles')->Where('slug', 'LIKE',"$temp%")->count();
        if($count > 0){
            $temp .= '-';
            $temp .= $count;
         }
        return $temp;
    }

    /**
     * Convert format date:dd-mm-yyyy to yyyy-mm-dd
     * * @param string $date
     */
    public static function formatDateYmd($date) {
        if(DateTime::createFromFormat('d/m/Y', $date)) {
            $formatDate = DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d');
            return $formatDate;
        } else {
            return $date;
        }
    }
}
