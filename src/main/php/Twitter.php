<?php declare(strict_types=1);

namespace SocialNetwork;

use RuntimeException;

require 'IObservable.php';

class Twitter implements IObservable
{

    //region private attributes
    private array $observers;
    //endregion private attributes

    protected $twits;

    public function __construct(array $observers = array())
    {
        $this->observers = $observers;
    }

    public function subscribe(array $observers):void
    {
        self::setObservers($observers);
    }

    public function unsubscribe(IObserver $observer):void
    {
        throw new RuntimeException();
    }

    public function notifyObservers():void
    {
        throw new EmptyListOfSubscribersException();
    }

    public function getObservers():array
    {

        if ($this->observers==null){
            return array();
        }

        return $this->observers;
    }

    public function getTwits():array
    {
        if ($this->twits==null){
            return array();
        }
        return $this->twits;
    }
    public function setTwits(array $twits):void
    {
        $this->twits = $twits;
    }
    public function setObservers(array $observers):void
    {
        if ($this->observers!=null){
            $allreadyIns=self::getObservers();
            //Pour tout les observateur existant as $observer
            foreach ($observers as $observer)
            {
                if (in_array($observer,$allreadyIns,true)){
                    throw new SubscriberAlreadyExistsException();
                }
            }
            foreach ($allreadyIns as $allreadyIn)
            {
                $this->observers[] = $allreadyIn;
            }


        }
        else
        {
            $this->observers = $observers;
        }
    }
}

class TwitterException extends RuntimeException { }
class EmptyListOfSubscribersException extends TwitterException { }
class SubscriberAlreadyExistsException extends TwitterException { }
class SubscriberNotFoundException extends TwitterException { }