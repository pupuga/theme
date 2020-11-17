<?php

namespace Pupuga\Libs\Curl;

class MailChimp
{
    public static $instance;
    private $key = null;
    private $urlBase;
    private $url;
    private $endPoint;
    private $dc;
    private $data;


    private function __construct($key)
    {
        if (is_null($this->key) && !empty($key)) {
            $this->key = $key;
        }

        $this->setDc()->setUrlBase();
    }

    /**
     * @return $this
     */
    static function app($key = null)
    {
        if (self::$instance === null) {
            self::$instance = new self($key);
        }
        return self::$instance;
    }

    /**
     * @return $this
     */
    private function setDc()
    {
        $this->dc = explode('-', $this->key)[1];

        return $this;
    }

    /**
     * @return $this
     */
    private function setUrlBase()
    {
        $this->urlBase = 'https://'.$this->dc.'.api.mailchimp.com/3.0';

        return $this;
    }

    /**
     * @return $this
     */
    private function setUrl()
    {
        $this->url = $this->urlBase . $this->endPoint;

        return $this;
    }

    private function connect($requestType)
    {
        if (is_null($this->key)) {
            die('public key must not be null');
        }

        $method = $requestType;

        return Curl::$method($this->url, $this->key, $this->data);
    }

    /**
     * @return $this
     */
    public function setEndPoint($endPoint)
    {
        $this->endPoint = $endPoint;
        $this->setUrl();

        return $this;
    }

    /**
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function get()
    {
        return $this->connect('get');
    }

    public function post()
    {
        return $this->connect('post');
    }

    public function delete()
    {
        return $this->connect('delete');
    }

    public function addSubscriber($listId, $email, $firstName, $lastName, $status = 'subscribed')
    {
        $result = $this
            ->setEndPoint("/lists/{$listId}/members")
            ->setData(array(
                'email_address' => $email,
                'status' => $status,
                'merge_fields' => array(
                    'FNAME' => $firstName,
                    'LNAME' => $lastName
                )
            ))
            ->post();

        return $result;
    }

    public function removeSubscriber($listId, $email)
    {
        $subscriberHash = md5($email);
        $result = $this
            ->setEndPoint("/lists/{$listId}/members/{$subscriberHash}")
            ->delete();

        return $result;
    }

    public function removeSubscriberFromLists(array $lists, $email)
    {
        $results = array();
        foreach ($lists as $key => $list) {
            $results[$key] = $this->removeSubscriber($list, $email);
        }

        return $results;
    }

}