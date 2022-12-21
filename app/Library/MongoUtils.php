<?php namespace App\Library;


use DateTime;
use DateTimeZone;
use Exception;
use MongoDB\BSON\UTCDateTime;

class MongoUtils {
	
	/**
	 * Converte um DateTime para formato do Mongo.
	 *
	 * @param $phpDate                          pode ser um DateTime ou uma string no formato 'Y-m-d H:i:s'
	 * @return UTCDateTime|null
	 * @throws Exception                       caso nao for um DateTime ou uma string
	 */
	public static function convertDatePhpToMongo($phpDate) {
		if ($phpDate == null) return null;
		if (is_string($phpDate)) {
			$mongoDate = new DateTime($phpDate);
		} else if ($phpDate instanceof DateTime) {
			$mongoDate = $phpDate;
		} else {
			throw new Exception("Erro convertendo data, tipo inválido! [ $phpDate ]");
		}
		return new UTCDateTime($mongoDate->getTimestamp() * 1000);
	}
	
	/**
	 * Converte uma data do formato do Mongo para String formatada 'Y-m-d H:i:s'.
	 *
	 * @param $mongoDate        data do mongo
	 * @param $format           formato de retorno da string
	 * @return string|null      retorna string formatada, ou null
	 */
	public static function convertDateMongoToPhpString($mongoDate, $format = null) {
		if ($mongoDate == null) return null;
		if (empty($format)) $format = 'Y-m-d H:i:s';
		return $mongoDate->toDateTime()->format($format);
	}
	
	
	/**
	 * Converte uma data do formato do Mongo para DateTime.
	 *
	 * @param $mongoDate        data do mongo
	 * @param $format           formato da data (normalmente isso eh padrao Y-m-d H:i:s, mas caso precise por exemplo retirar a hora...)
	 * @return DateTime|null   retorna um DateTime ou null
	 */
	public static function convertDateMongoToPhpDateTime($mongoDate, $format = null, $timeZone = null) {
		if ($mongoDate == null)
			return null;
		if (empty($format))
			$format = 'Y-m-d H:i:s';
		if ($timeZone)
			return new DateTime($mongoDate->toDateTime()->format($format), new DateTimeZone($timeZone));
		else
			return new DateTime($mongoDate->toDateTime()->format($format));
	}
	
}
