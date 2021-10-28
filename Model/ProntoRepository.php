<?php 
namespace Cda\Pronto\Model;
 
use Magento\Store\Model\ScopeInterface;
use Cda\Pronto\Api\ProntoRepositoryInterface;

//Http integration
// use GuzzleHttp\Client;
// use GuzzleHttp\ClientFactory;
// use GuzzleHttp\Exception\GuzzleException;
// use GuzzleHttp\Psr7\Response;
// use GuzzleHttp\Psr7\ResponseFactory;
// use Magento\Framework\Webapi\Rest\Request;
//curl
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Exception\CouldNotSaveException;

use function GuzzleHttp\json_decode;

class ProntoRepository implements ProntoRepositoryInterface{

	protected $url;
	protected $username;
	protected $password;
	protected $helperData;

     /**
     * API request URL
     */
    const API_REQUEST_URI = 'https://api.github.com/';

    /**
     * API request endpoint
     */
    const API_REQUEST_ENDPOINT = 'repos/';

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * GitApiService constructor
     *
     * @param ClientFactory $clientFactory
     * @param ResponseFactory $responseFactory
     */
    public function __construct(
        Curl $curl,
        // ClientFactory $clientFactory,
		// ResponseFactory $responseFactory,
        \Cda\Pronto\Helper\Data $helperData
    ) {
        $this->_curl = $curl;
        // $this->clientFactory = $clientFactory;
        // $this->responseFactory = $responseFactory;
        $this->helperData = $helperData;
        
    }

	/**
	 * {@inheritdoc}
	 */
	public function getProntoLoginToken()
	{
        
        $this->url = $this->helperData->getGeneralConfig('url');
        $this->username = $this->helperData->getGeneralConfig('username');
        $this->password = $this->helperData->getGeneralConfig('password');

        try{
            $loginUrl = $this->url ."/login";
            $body = [];
            $this->_curl->addHeader("X-Pronto-Username", $this->username);
            $this->_curl->addHeader("X-Pronto-Password", $this->password);
            $this->_curl->addHeader("X-Pronto-Content-Type", 'application/json');
            $this->_curl->post($loginUrl, json_encode($body));
            $response = (array) json_decode($this->_curl->getBody());
            if(array_key_exists('AuthInfo', $response)){
                $authInfo = (array)$response['AuthInfo'];
                if(array_key_exists('token', $authInfo)){
                    $token = $authInfo["token"];
                    return  $token;
                }else{
                    throw new CouldNotSaveException(__("unable to fetch token ".json_encode($response)));
                }
            }else{
                throw new CouldNotSaveException(__("unable to fetch token ".json_encode($response)));
            }
            
        }catch(\Exception $e){
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        
		return false;//TODO remove return type true
	}

	public function setRetailAccountPronto($retailCustomerData)
	{
        try{    
            $token = $this->getProntoLoginToken();
            
            $createUrl = $this->url ."/api/CusPostNewCustomer";
            
            $this->_curl->addHeader("X-Pronto-Token", $token);
            $this->_curl->addHeader("X-Pronto-Content-Type", 'application/json');

            // TODO: body of reatil has to be changed
            $body = [
                "CusPostNewCustomer"=>[
                    "Customer"=>[
                        "CustomerName"=>"FirstName 1",
                        "BillToName"=>"LastName1",
                        // "CustomerCode"=>"TEST003",
                        // "CreditLimitCode"=>"1",
                        // "Address1"=>"2 Test Street 9",
                        // "Address2"=>"Testvill 9",
                        // "Address3"=>"state",
                        // "AddressPostCode"=>"4000",
                        // "TerritoryCode"=>"5410",
                        // "WarehouseCode"=>"5410"
                    ]
                ]
                    ];
            $this->_curl->post($createUrl, json_encode($body));
            $response = (array)json_decode($this->_curl->getBody());
            $responceCusPost = (array)$response["CusPostNewCustomerResponse"];
            $apiResponce = (array)$responceCusPost["APIResponseStatus"];
            
            if($apiResponce["Code"] =="OK"){
                return true;
            }else{
                throw new CouldNotSaveException(__("unable to fetch status code ".json_encode($response)));
            }
            
            // TODO: return type need to be corrected and exception are missing
            
        }catch(\Exception $e){
            throw new CouldNotSaveException(__($e->getMessage()));
        }
		
	}

    public function getTradeAccount($customerFullName){
        return true;
    }
}
