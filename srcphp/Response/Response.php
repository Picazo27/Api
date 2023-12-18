<?php
namespace proyecto\Response;

class Response
{

	protected $status = 200;
	protected $message;

	// Se cambio esta linea para poder aceptar peticiones
	protected $headers = array(
		'Cache-Control: no-cache',                  // Evitar el almacenamiento en caché en la ruta
		'Pragma: no-cache',                         // Lo mismo (por si acaso)
		'Content-Type: application/json; charset=utf-8', // Tipo de medio MIME para una respuesta JSON
		'Access-Control-Allow-Origin: *',          // Permitir peticiones AJAX entre dominios
		'Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With',
		'Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'
	);


	function __construct()
	{

	} //

	// Add a response header to be sent
//------------------------------------------------------------------
	protected function header($content)
	{
		$this->headers[] = $content;
	} //

	// Send the response
//------------------------------------------------------------------
	public function Send()
	{

		// Clear output buffer
		ob_clean();
		ob_start();

		$R = new \stdClass;
		$R->status = $this->status;
		if (!empty($this->message)) {
			$R->msg = $this->message;
		}
		;
		if (isset($this->data)) {
			$R->data = $this->data;
		}
		;

		// If set, include Request in response
		if (defined('RESPOND_WITH_REQUEST') && RESPOND_WITH_REQUEST) {
			$R->_Request = $GLOBALS['Request'];
		}
		;


		// Set all headers

		//        $this->header('Rest-Token: '.TOKEN);
		//$this->header('Rest-Server: '.SERVER_NAME);
		//$this->header('Rest-Server-Version: '.SERVICE_VERSION);
		foreach ($this->headers as $header) {
			header($header, true);
		}
		;
		echo json_encode($R);
		die();
	} //

}
; // end class Response
