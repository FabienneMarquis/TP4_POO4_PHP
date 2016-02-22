<?php


class PDO2 extends PDO
{
	
	/**
	 * Le pointeur qui va éventuellement recevoir l'objet de connection.
	 */
	private static $_instance;

	/**
	 * Constructeur : héritage public obligatoire par héritage de PDO.
	 */
	public function __construct()
	{}

	/**
	 * Permet d'acquérir l'objet PDO.
	 * S'il n'existe pas il sera créé.
	 *
	 * @return PDO2, le seul objet de la présente classe.
	 */
	public static function getInstance()
	{
		if (! isset(self::$_instance))
		{
			try
			{
				
				self::$_instance = new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD);
			}
			catch (PDOException $e)
			{
				
				echo $e;
			}
		}
		
		return self::$_instance;
	}
}