<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('number_to_words')) {
	function number_to_words($number)  {
		$before_comma=trim(to_word($number));
		$after_comma=trim(comma($number));
		if ($after_comma) {
			$koma=' koma '.$after_comma;
		} else {
			$koma='';
		}
		return ucwords($results=$before_comma.$koma);
	}

	function to_word($number) {
		$word="";
		$arr_number=array("","satu","dua","tiga","empat","lima","enam","tujuh","delapan","sembilan","sepuluh","sebelas");
		if($number<12) {
			$word=" ".$arr_number[$number];
		} else if($number<20) {
			$word=to_word($number-10)." belas";
		} else if($number<100) {
			$word=to_word($number/10)." puluh ".to_word($number%10);
		} else if($number<200) {
			$word="seratus ".to_word($number-100);
		} else if($number<1000) {
			$word=to_word($number/100)." ratus ".to_word($number%100);
		} else if($number<2000) {
			$word="seribu ".to_word($number-1000);
		} else if($number<1000000) {
			$word=to_word($number/1000)." ribu ".to_word($number%1000);
		} else if($number<1000000000) {
			$word=to_word($number/1000000)." juta ".to_word($number%1000000);
		} else if($number<1000000000000) {
			$word=to_word($number/1000000000)." milyar ".to_word(fmod($number,1000000000));
		} else {
			$word="undefined";
		}
		return $word;
	}

	function comma($number) {
		$after_comma=stristr($number,',');
		$arr_numbe=array("nol","satu","dua","tiga","empat","lima","enam","tujuh","delapan","sembilan");
		$results="";
		$length=strlen($after_comma);
		$i=1;
		while($i<$length) {
			$ge=substr($after_comma,$i,1);
			$results.=" ".$arr_number[$get];
			$i++;
		}
		return $results;
	}
}