<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class MaincontrollerCheck  implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
        //if segment 1 == maincontroller, the user still have access to the private data
        //we have to redirect the request to the second segement to protect the page
        $uri = service('uri');
        $segment='';
        if($uri->getSegment(1) == 'maincontroller'){
            if ($uri->getSegment(2) == '')
                $segment ='/html';
            else
                $segment ='/html/'. $uri->getSegment(2);
           return redirect()->to($segment);
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
