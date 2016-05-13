<?php

namespace DoctrineProxies\__CG__\Meritocracy\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class User extends \Meritocracy\Entity\User implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', 'rules', 'id', 'firstName', 'lastName', 'avatar', 'telephone', 'mobilePhone', 'email', 'hash', 'userAgent', 'address', 'linkedinId', 'facebookId', 'referral', 'zip', 'isPremium', 'status', 'gender', 'type', '' . "\0" . 'Meritocracy\\Entity\\User' . "\0" . 'birthdate', 'attachments', 'vacancies', 'applications', 'workExperiences', 'educations', 'company', 'languages', 'events', 'associations', 'qualifications', 'userEvents', 'scores', 'contactRequests', 'assignedRequests', '' . "\0" . 'Meritocracy\\Entity\\User' . "\0" . 'city', '' . "\0" . 'Meritocracy\\Entity\\User' . "\0" . 'source', 'password', 'cityPlainText', 'onePageCrmUsername', 'onePageCrmPassword', 'rememberToken', 'createdAt', 'updatedAt', 'refererUrl', 'importId'];
        }

        return ['__isInitialized__', 'rules', 'id', 'firstName', 'lastName', 'avatar', 'telephone', 'mobilePhone', 'email', 'hash', 'userAgent', 'address', 'linkedinId', 'facebookId', 'referral', 'zip', 'isPremium', 'status', 'gender', 'type', '' . "\0" . 'Meritocracy\\Entity\\User' . "\0" . 'birthdate', 'attachments', 'vacancies', 'applications', 'workExperiences', 'educations', 'company', 'languages', 'events', 'associations', 'qualifications', 'userEvents', 'scores', 'contactRequests', 'assignedRequests', '' . "\0" . 'Meritocracy\\Entity\\User' . "\0" . 'city', '' . "\0" . 'Meritocracy\\Entity\\User' . "\0" . 'source', 'password', 'cityPlainText', 'onePageCrmUsername', 'onePageCrmPassword', 'rememberToken', 'createdAt', 'updatedAt', 'refererUrl', 'importId'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (User $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setId', [$id]);

        return parent::setId($id);
    }

    /**
     * {@inheritDoc}
     */
    public function getFirstName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFirstName', []);

        return parent::getFirstName();
    }

    /**
     * {@inheritDoc}
     */
    public function setFirstName($firstName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFirstName', [$firstName]);

        return parent::setFirstName($firstName);
    }

    /**
     * {@inheritDoc}
     */
    public function getAvatar()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAvatar', []);

        return parent::getAvatar();
    }

    /**
     * {@inheritDoc}
     */
    public function setAvatar($avatar)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAvatar', [$avatar]);

        return parent::setAvatar($avatar);
    }

    /**
     * {@inheritDoc}
     */
    public function getLastName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLastName', []);

        return parent::getLastName();
    }

    /**
     * {@inheritDoc}
     */
    public function setLastName($lastName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLastName', [$lastName]);

        return parent::setLastName($lastName);
    }

    /**
     * {@inheritDoc}
     */
    public function getTelephone()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTelephone', []);

        return parent::getTelephone();
    }

    /**
     * {@inheritDoc}
     */
    public function setTelephone($telephone)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTelephone', [$telephone]);

        return parent::setTelephone($telephone);
    }

    /**
     * {@inheritDoc}
     */
    public function getMobilePhone()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMobilePhone', []);

        return parent::getMobilePhone();
    }

    /**
     * {@inheritDoc}
     */
    public function getAssociations()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAssociations', []);

        return parent::getAssociations();
    }

    /**
     * {@inheritDoc}
     */
    public function setAssociations($associations)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAssociations', [$associations]);

        return parent::setAssociations($associations);
    }

    /**
     * {@inheritDoc}
     */
    public function getQualifications()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getQualifications', []);

        return parent::getQualifications();
    }

    /**
     * {@inheritDoc}
     */
    public function setQualifications($qualifications)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setQualifications', [$qualifications]);

        return parent::setQualifications($qualifications);
    }

    /**
     * {@inheritDoc}
     */
    public function getAssignedRequests()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAssignedRequests', []);

        return parent::getAssignedRequests();
    }

    /**
     * {@inheritDoc}
     */
    public function setAssignedRequests($assignedRequests)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAssignedRequests', [$assignedRequests]);

        return parent::setAssignedRequests($assignedRequests);
    }

    /**
     * {@inheritDoc}
     */
    public function getOnePageCrmUsername()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOnePageCrmUsername', []);

        return parent::getOnePageCrmUsername();
    }

    /**
     * {@inheritDoc}
     */
    public function setOnePageCrmUsername($onePageCrmUsername)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOnePageCrmUsername', [$onePageCrmUsername]);

        return parent::setOnePageCrmUsername($onePageCrmUsername);
    }

    /**
     * {@inheritDoc}
     */
    public function getLinkedinId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLinkedinId', []);

        return parent::getLinkedinId();
    }

    /**
     * {@inheritDoc}
     */
    public function setLinkedinId($linkedinId)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLinkedinId', [$linkedinId]);

        return parent::setLinkedinId($linkedinId);
    }

    /**
     * {@inheritDoc}
     */
    public function getFacebookId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFacebookId', []);

        return parent::getFacebookId();
    }

    /**
     * {@inheritDoc}
     */
    public function setFacebookId($facebookId)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFacebookId', [$facebookId]);

        return parent::setFacebookId($facebookId);
    }

    /**
     * {@inheritDoc}
     */
    public function getOnePageCrmPassword()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOnePageCrmPassword', []);

        return parent::getOnePageCrmPassword();
    }

    /**
     * {@inheritDoc}
     */
    public function setOnePageCrmPassword($onePageCrmPassword)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOnePageCrmPassword', [$onePageCrmPassword]);

        return parent::setOnePageCrmPassword($onePageCrmPassword);
    }

    /**
     * {@inheritDoc}
     */
    public function getContactRequests()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getContactRequests', []);

        return parent::getContactRequests();
    }

    /**
     * {@inheritDoc}
     */
    public function setContactRequests($contactRequests)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setContactRequests', [$contactRequests]);

        return parent::setContactRequests($contactRequests);
    }

    /**
     * {@inheritDoc}
     */
    public function addAttachment($contactRequests)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addAttachment', [$contactRequests]);

        return parent::addAttachment($contactRequests);
    }

    /**
     * {@inheritDoc}
     */
    public function addContactRequest($contactRequests)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addContactRequest', [$contactRequests]);

        return parent::addContactRequest($contactRequests);
    }

    /**
     * {@inheritDoc}
     */
    public function setMobilePhone($mobilePhone)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMobilePhone', [$mobilePhone]);

        return parent::setMobilePhone($mobilePhone);
    }

    /**
     * {@inheritDoc}
     */
    public function getRefererUrl()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRefererUrl', []);

        return parent::getRefererUrl();
    }

    /**
     * {@inheritDoc}
     */
    public function setRefererUrl($refererUrl)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRefererUrl', [$refererUrl]);

        return parent::setRefererUrl($refererUrl);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmail()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEmail', []);

        return parent::getEmail();
    }

    /**
     * {@inheritDoc}
     */
    public function setEmail($email)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEmail', [$email]);

        return parent::setEmail($email);
    }

    /**
     * {@inheritDoc}
     */
    public function getHash()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHash', []);

        return parent::getHash();
    }

    /**
     * {@inheritDoc}
     */
    public function setHash($hash)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHash', [$hash]);

        return parent::setHash($hash);
    }

    /**
     * {@inheritDoc}
     */
    public function getUserAgent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUserAgent', []);

        return parent::getUserAgent();
    }

    /**
     * {@inheritDoc}
     */
    public function getAddress()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAddress', []);

        return parent::getAddress();
    }

    /**
     * {@inheritDoc}
     */
    public function setAddress($address)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAddress', [$address]);

        return parent::setAddress($address);
    }

    /**
     * {@inheritDoc}
     */
    public function setUserAgent($userAgent)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUserAgent', [$userAgent]);

        return parent::setUserAgent($userAgent);
    }

    /**
     * {@inheritDoc}
     */
    public function getReferral()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getReferral', []);

        return parent::getReferral();
    }

    /**
     * {@inheritDoc}
     */
    public function setReferral($referral)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setReferral', [$referral]);

        return parent::setReferral($referral);
    }

    /**
     * {@inheritDoc}
     */
    public function getZip()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getZip', []);

        return parent::getZip();
    }

    /**
     * {@inheritDoc}
     */
    public function setZip($zip)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setZip', [$zip]);

        return parent::setZip($zip);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsPremium()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsPremium', []);

        return parent::getIsPremium();
    }

    /**
     * {@inheritDoc}
     */
    public function setIsPremium($isPremium)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsPremium', [$isPremium]);

        return parent::setIsPremium($isPremium);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatus', []);

        return parent::getStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus($status)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatus', [$status]);

        return parent::setStatus($status);
    }

    /**
     * {@inheritDoc}
     */
    public function getGender()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGender', []);

        return parent::getGender();
    }

    /**
     * {@inheritDoc}
     */
    public function setGender($gender)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGender', [$gender]);

        return parent::setGender($gender);
    }

    /**
     * {@inheritDoc}
     */
    public function getType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getType', []);

        return parent::getType();
    }

    /**
     * {@inheritDoc}
     */
    public function setType($type)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setType', [$type]);

        return parent::setType($type);
    }

    /**
     * {@inheritDoc}
     */
    public function getBirthdate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBirthdate', []);

        return parent::getBirthdate();
    }

    /**
     * {@inheritDoc}
     */
    public function setBirthdate($birthdate)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBirthdate', [$birthdate]);

        return parent::setBirthdate($birthdate);
    }

    /**
     * {@inheritDoc}
     */
    public function getVacancies()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVacancies', []);

        return parent::getVacancies();
    }

    /**
     * {@inheritDoc}
     */
    public function setVacancies($vacancies)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVacancies', [$vacancies]);

        return parent::setVacancies($vacancies);
    }

    /**
     * {@inheritDoc}
     */
    public function getApplications()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getApplications', []);

        return parent::getApplications();
    }

    /**
     * {@inheritDoc}
     */
    public function setApplications($applications)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setApplications', [$applications]);

        return parent::setApplications($applications);
    }

    /**
     * {@inheritDoc}
     */
    public function getWorkExperiences()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getWorkExperiences', []);

        return parent::getWorkExperiences();
    }

    /**
     * {@inheritDoc}
     */
    public function setWorkExperiences($workExperiences)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setWorkExperiences', [$workExperiences]);

        return parent::setWorkExperiences($workExperiences);
    }

    /**
     * {@inheritDoc}
     */
    public function addWorkExperience($work)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addWorkExperience', [$work]);

        return parent::addWorkExperience($work);
    }

    /**
     * {@inheritDoc}
     */
    public function getEducations()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEducations', []);

        return parent::getEducations();
    }

    /**
     * {@inheritDoc}
     */
    public function addEducation($education)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addEducation', [$education]);

        return parent::addEducation($education);
    }

    /**
     * {@inheritDoc}
     */
    public function addAssociation($education)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addAssociation', [$education]);

        return parent::addAssociation($education);
    }

    /**
     * {@inheritDoc}
     */
    public function addQualification($education)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addQualification', [$education]);

        return parent::addQualification($education);
    }

    /**
     * {@inheritDoc}
     */
    public function setEducations($educations)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEducations', [$educations]);

        return parent::setEducations($educations);
    }

    /**
     * {@inheritDoc}
     */
    public function getCityPlainText()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCityPlainText', []);

        return parent::getCityPlainText();
    }

    /**
     * {@inheritDoc}
     */
    public function setCityPlainText($cityPlainText)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCityPlainText', [$cityPlainText]);

        return parent::setCityPlainText($cityPlainText);
    }

    /**
     * {@inheritDoc}
     */
    public function getPassword()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPassword', []);

        return parent::getPassword();
    }

    /**
     * {@inheritDoc}
     */
    public function setPassword($password)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPassword', [$password]);

        return parent::setPassword($password);
    }

    /**
     * {@inheritDoc}
     */
    public function getCompany()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCompany', []);

        return parent::getCompany();
    }

    /**
     * {@inheritDoc}
     */
    public function setCompany($company)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCompany', [$company]);

        return parent::setCompany($company);
    }

    /**
     * {@inheritDoc}
     */
    public function getLanguages()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLanguages', []);

        return parent::getLanguages();
    }

    /**
     * {@inheritDoc}
     */
    public function setLanguages($languages)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLanguages', [$languages]);

        return parent::setLanguages($languages);
    }

    /**
     * {@inheritDoc}
     */
    public function getEvents()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEvents', []);

        return parent::getEvents();
    }

    /**
     * {@inheritDoc}
     */
    public function addEvent($event)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addEvent', [$event]);

        return parent::addEvent($event);
    }

    /**
     * {@inheritDoc}
     */
    public function setEvents($events)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEvents', [$events]);

        return parent::setEvents($events);
    }

    /**
     * {@inheritDoc}
     */
    public function getScores()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getScores', []);

        return parent::getScores();
    }

    /**
     * {@inheritDoc}
     */
    public function setScores($scores)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setScores', [$scores]);

        return parent::setScores($scores);
    }

    /**
     * {@inheritDoc}
     */
    public function getCity()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCity', []);

        return parent::getCity();
    }

    /**
     * {@inheritDoc}
     */
    public function setCity($city)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCity', [$city]);

        return parent::setCity($city);
    }

    /**
     * {@inheritDoc}
     */
    public function getRules()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRules', []);

        return parent::getRules();
    }

    /**
     * {@inheritDoc}
     */
    public function prePersist()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'prePersist', []);

        return parent::prePersist();
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreatedAt', []);

        return parent::getCreatedAt();
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdatedAt', []);

        return parent::getUpdatedAt();
    }

    /**
     * {@inheritDoc}
     */
    public function setCreatedAt(\DateTime $createdAt)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreatedAt', [$createdAt]);

        return parent::setCreatedAt($createdAt);
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdatedAt', [$updatedAt]);

        return parent::setUpdatedAt($updatedAt);
    }

    /**
     * {@inheritDoc}
     */
    public function getUserEvents()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUserEvents', []);

        return parent::getUserEvents();
    }

    /**
     * {@inheritDoc}
     */
    public function setUserEvents($userEvents)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUserEvents', [$userEvents]);

        return parent::setUserEvents($userEvents);
    }

    /**
     * {@inheritDoc}
     */
    public function addUserEvent($userEvents)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addUserEvent', [$userEvents]);

        return parent::addUserEvent($userEvents);
    }

    /**
     * {@inheritDoc}
     */
    public function addLanguage($language)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addLanguage', [$language]);

        return parent::addLanguage($language);
    }

    /**
     * {@inheritDoc}
     */
    public function getSource()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSource', []);

        return parent::getSource();
    }

    /**
     * {@inheritDoc}
     */
    public function setSource($source)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSource', [$source]);

        return parent::setSource($source);
    }

    /**
     * {@inheritDoc}
     */
    public function getRememberToken()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRememberToken', []);

        return parent::getRememberToken();
    }

    /**
     * {@inheritDoc}
     */
    public function setRememberToken($rememberToken)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRememberToken', [$rememberToken]);

        return parent::setRememberToken($rememberToken);
    }

    /**
     * {@inheritDoc}
     */
    public function getAttachments()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAttachments', []);

        return parent::getAttachments();
    }

    /**
     * {@inheritDoc}
     */
    public function setAttachments($attachments)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAttachments', [$attachments]);

        return parent::setAttachments($attachments);
    }

    /**
     * {@inheritDoc}
     */
    public function generatePermalink($text)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'generatePermalink', [$text]);

        return parent::generatePermalink($text);
    }

    /**
     * {@inheritDoc}
     */
    public function getImportId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getImportId', []);

        return parent::getImportId();
    }

    /**
     * {@inheritDoc}
     */
    public function setImportId($importId)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setImportId', [$importId]);

        return parent::setImportId($importId);
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthIdentifierName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAuthIdentifierName', []);

        return parent::getAuthIdentifierName();
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthIdentifier()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAuthIdentifier', []);

        return parent::getAuthIdentifier();
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthPassword()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAuthPassword', []);

        return parent::getAuthPassword();
    }

    /**
     * {@inheritDoc}
     */
    public function getRememberTokenName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRememberTokenName', []);

        return parent::getRememberTokenName();
    }

    /**
     * {@inheritDoc}
     */
    public function getEmailForPasswordReset()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEmailForPasswordReset', []);

        return parent::getEmailForPasswordReset();
    }

}