<?php
/**
 *
 * groupsClient is a proof-of-concept or future code sample for connecting to 
 * the Groups Web Service with PHP.
 *
 * Groups Web Service Users Guide
 * http://wiki.cac.washington.edu/display/groups/Groups+Web+Service+Users+Guide 
 *
 * Adam Graffunder June 2008
 * 
 * personClient is based on the above code
 *
 * courseClient is based on personClient
 */

// make sure curl and dom are installed
// if (! extension_loaded(curl))
//     print "The cURL library is not installed, but it is required for the client.";

// if (! extension_loaded(dom))
//     print "The dom library is not installed, but it is required for the client.";

class courseClient 
{
    // Config portion
    private $course_service_url; 
    // end config portion

    private $ch; //cURL handle
    private $cn; //the CommonName in your certificate
    private $response; //http response 
    private $reponse_code; //http response code
    // TODO Make a decision
    private $json; //json object 
    private $xhtml; //xhtml object 
    // /TODO Make a decision
    private $errors = array(); // stores errors
    private $XML_template; // stores a template for creating PUT request XML
    private $put_data; // stores data to be sent in a PUT request
    private $etag; // the last etag sent by the server

    public $debug = False; // turns on debugging output

    /**
     * Contructor collects info necessary to connect to the service
     */
    public function __construct($config) 
    {
        if($config)
        {
            $this->course_service_url       = $config['service_url'];
            $this->debug                    = $config['debug'];
        }
        else
        {
            die("You must provide Client with some config info\n");
        }

        $this->ch = curl_init();
        // $cert = openssl_x509_parse(file_get_contents($this->cert_file_path));
        // $this->cn = $cert['subject']['CN'];

        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1); //return the transfer from curl_exec as a string instead of printing it. 
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt($this->ch, CURLOPT_HEADER, 1); // include header in response so we can get the etag.

    }

    public function __destruct() 
    {
        if ($this->ch)
        {
            curl_close($this->ch);
        }
    }

    /**
     * displayJson gets course metadata via json
     *
     * @param	string	$type	The type of information
     *
     */
    public function displayJson($type) 
    {
        if ( $this->sendRequest($type . '.json') ) 
        {
            return $this->json;
        } 
        else 
        {
            $this->printErrors();
        }
    }

    /**
     * displayForm gets person metadata
     *
     * @param	string	$netid	The netid or regid.
     *
     */
    // public function displayForm() 
    // {
    //     if ( $this->sendRequest('college.json') ) 
    //     {
    //         return $this->json;
    //     } 
    //     else 
    //     {
    //         $this->printErrors();
    //     }
    // }

    /**
     * readCourse gets person metadata
     *
     * @param	string	$course	The comma separated course
     * /student/v4/course/2010,autumn,D HYG,401.json 
     *
     */
    // TODO - No idea how to do this
    public function readCourse($course) 
    {
        // if ( $this->sendRequest('course' . $course . '.json') ) 
        if ( $this->sendRequest('course' . $course ) )
        {
            $results = $this->json;
            return $results;
        } 
        else 
        {
            // $this->printErrors();
            return false;
        }
    }

    /**
     * search searches for a group by stem, member, type, or owner.
     *
     * @param	string	$key	This specifies what you're searching by. Valid keys are stem, member, type, or owner.
     * @param	string	$value	This is the value you're using to search, or the query string.
     *
     */
    public function search($type, $key, $value) 
    {
        $value = urlencode($value);

        if ( $this->sendRequest($type . '.json?page_size=50&future_terms=2&' . $key . '=' . $value) ) 
        {
            $results = $this->json;
            // $results = $this->xhtml;
            return $results;

        } 
        else 
        {
            $this->printErrors();
        }
    }

    /**
     * sendRequest takes a resource, requests it, and handles non-success 
     * responses.
     *
     * @param	string	$resource	The part of the URL after the WebService URL base.
     * @param	string	$method		The type of request you want to do. Defaults to GET.
     *
     * @return	bool				True on a successful request, otherwise False.
     */
    private function sendRequest($resource, $method='GET') 
    {
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($method == 'PUT') 
        {
            curl_setopt($this->ch, CURLOPT_PUT, True);
        }

        // construct URL
        curl_setopt($this->ch, CURLOPT_URL, $this->course_service_url . $resource);
        curl_setopt($this->ch, CURLOPT_PORT , 443); 
        curl_setopt($this->ch, CURLINFO_HEADER_OUT, True);

        // send request
        $this->response = curl_exec($this->ch);

        // split off header from response
        $header_size = curl_getinfo($this->ch, CURLINFO_HEADER_SIZE);
        $result_header = substr($this->response, 0, $header_size);

        if ( preg_match('/ETag:\h(\S+)/m', $result_header, $etagArray) == 1 ) 
        {
            $this->etag = $etagArray[1];
        }

        // debugging test
        if ( $this->debug ) 
        {
            curl_setopt($this->ch, CURLOPT_VERBOSE, True);

            print "<!-- debugging output -->\n";
            print "<!-- current etag -->$this->etag<!-- end etag -->\n";
            if( $method == 'PUT' ) 
            {
                print "<!-- request XML -->\n$this->put_data\n<!-- end request XML -->\n";
            }

            print "<!-- this is the response from the request \"" . curl_getinfo($this->ch, CURLINFO_EFFECTIVE_URL) . "\" -->\n$this->response\n<!-- end response -->\n";

            print "<!-- response headers -->\n";
            print $result_header;
            print "<!-- end response headers -->\n";

            print "<!-- These are the headers of the last cURL transfer -->\n";
            print_r(curl_getinfo($this->ch, CURLINFO_HEADER_OUT));
            print "<!-- end curl headers-->\n";

            print "<!-- Here are the curl_info output. -->\n";
            print_r(curl_getinfo($this->ch));
            print "<!-- end curl_info output. -->\n";

            print "<!-- end debugging output -->\n";
        }

        // trim response to portion after header
        $this->response = substr($this->response, $header_size, strlen($this->response));

        // check response code
        $this->response_code = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);

        // No Response
        if ( $this->response )
        {
            $this->json = $this->response;
        } 
        else 
        {
            $this->errors[] = 'Could not decode response.';
            return false;
        }

        switch  ($this->response_code) 
        {
        case 200:
        case 201:
            return true;
        case 404:
            $this->errors[] = "Not Found (\"$this->response_code\").\n";
            return false;
        default:
            // $this->errors[] = $this->dxp->evaluate("//*[@class='error_message']")->item(0)->nodeValue;
            $this->errors[] = "The HTTP reponse code was \"$this->response_code\" and your request was \"" . curl_getinfo($this->ch, CURLINFO_EFFECTIVE_URL) . "\".\n";
            return false;
        }
    }

	/**
	 * setEtag just does a read for a group and sets the class var to the etag 
	 * for that group.
	 *
	 * @param	string	$group_id		A valid group namne or regid.
	 */
	// private function setEtag($group_id) 
    // {
	// 	// do a read group request for the etag.	
	// 	$this->readGroup($group_id);
    //     curl_setopt($this->ch, CURLOPT_HTTPHEADER, array("If-Match: $this->etag"));
	// }

    /**
     * returnErrors returns an error heading and any error messages that have 
     * accumulated, then clears the error array.
     */
    public function returnErrors() 
    {
        $this->errors = array();
        return "FAIL." . implode('<br/>', $this->errors) . "</p>\n\n";
    }

    /**
     * printErrors prints an error heading and any error messages that have 
     * accumulated, then clears the error array.
     */
    public function printErrors() 
    {
        print "<h3>FAIL.</h3>\n<p>" . implode('<br/>', $this->errors) . "</p>\n\n";
        $this->errors = array();
        return;
    }
}
?>

<?
// $course = new courseClient(array(
//  'cert_key_file'        => '',
//  'cert_authority_file'  => '',
//  'service_url'          => 'https://iam-ws.u.washington.edu/test_sws/v1/',
//  'debug'                => False,
//  ));
// 
// $testGroupName = 'u_YOURNETID_testgroup';
// 
// print_r($course->createGroup(array($testGroupName), 'this group was created by a PHP code sample.', array(), array(), array('YOURNETID', 'NETID')));
// 
// print_r($course->readGroup($testGroupName));
// 
// print_r($course->readGroupMembership($testGroupName));
// 
// print_r($course->search('stem', 'u_agraf'));
// 
// if($course->isMember('u:agraf:test123', array('tange', 'mcrawfor'))){
//     print "is member\n";
// }else{
//     print "not member\n";
// }
// 
// print_r($course->updateGroup($testGroupName, 'This group was updated', array(), array(), array('NETID', 'YOURNETID')));
// 
// if($course->addMembers($testGroupName, array('tange'))){
//     print "members added\n";
// }
// 
// if($course->deleteMembers($testGroupName, array('tange'))){
//     print "members deleted\n";
// }
// 
// if($course->deleteGroup($testGroupName)){
//     print "is member\n";
// 
// }
?>
