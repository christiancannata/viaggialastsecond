<?php

namespace DoctrineProxies\__CG__\Meritocracy\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class WeightsCvm extends \Meritocracy\Entity\WeightsCvm implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', 'rules', 'id', 'skillsMap', 'skillsWeight', 'skills', 'education', 'language', 'fragmentation', 'jobFunction', 'industry', 'seniority', 'softSkills', 'hardSkills', 'rho', 'threshold', 'vacancy', 'lastUpdateStatus', 'createdAt', 'updatedAt', 'importId'];
        }

        return ['__isInitialized__', 'rules', 'id', 'skillsMap', 'skillsWeight', 'skills', 'education', 'language', 'fragmentation', 'jobFunction', 'industry', 'seniority', 'softSkills', 'hardSkills', 'rho', 'threshold', 'vacancy', 'lastUpdateStatus', 'createdAt', 'updatedAt', 'importId'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (WeightsCvm $proxy) {
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
    public function getRules()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRules', []);

        return parent::getRules();
    }

    /**
     * {@inheritDoc}
     */
    public function setRules($rules)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRules', [$rules]);

        return parent::setRules($rules);
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
    public function getTotal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTotal', []);

        return parent::getTotal();
    }

    /**
     * {@inheritDoc}
     */
    public function setTotal($total)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTotal', [$total]);

        return parent::setTotal($total);
    }

    /**
     * {@inheritDoc}
     */
    public function getSkills()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSkills', []);

        return parent::getSkills();
    }

    /**
     * {@inheritDoc}
     */
    public function setSkills($skills)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSkills', [$skills]);

        return parent::setSkills($skills);
    }

    /**
     * {@inheritDoc}
     */
    public function getEducation()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEducation', []);

        return parent::getEducation();
    }

    /**
     * {@inheritDoc}
     */
    public function setEducation($education)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEducation', [$education]);

        return parent::setEducation($education);
    }

    /**
     * {@inheritDoc}
     */
    public function getLanguage()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLanguage', []);

        return parent::getLanguage();
    }

    /**
     * {@inheritDoc}
     */
    public function setLanguage($language)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLanguage', [$language]);

        return parent::setLanguage($language);
    }

    /**
     * {@inheritDoc}
     */
    public function getFragmentation()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFragmentation', []);

        return parent::getFragmentation();
    }

    /**
     * {@inheritDoc}
     */
    public function setFragmentation($fragmentation)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFragmentation', [$fragmentation]);

        return parent::setFragmentation($fragmentation);
    }

    /**
     * {@inheritDoc}
     */
    public function getJobFunction()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getJobFunction', []);

        return parent::getJobFunction();
    }

    /**
     * {@inheritDoc}
     */
    public function setJobFunction($jobFunction)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setJobFunction', [$jobFunction]);

        return parent::setJobFunction($jobFunction);
    }

    /**
     * {@inheritDoc}
     */
    public function getIndustry()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIndustry', []);

        return parent::getIndustry();
    }

    /**
     * {@inheritDoc}
     */
    public function setIndustry($industry)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIndustry', [$industry]);

        return parent::setIndustry($industry);
    }

    /**
     * {@inheritDoc}
     */
    public function getSeniority()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSeniority', []);

        return parent::getSeniority();
    }

    /**
     * {@inheritDoc}
     */
    public function setSeniority($seniority)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSeniority', [$seniority]);

        return parent::setSeniority($seniority);
    }

    /**
     * {@inheritDoc}
     */
    public function getSoftSkills()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSoftSkills', []);

        return parent::getSoftSkills();
    }

    /**
     * {@inheritDoc}
     */
    public function setSoftSkills($softSkills)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSoftSkills', [$softSkills]);

        return parent::setSoftSkills($softSkills);
    }

    /**
     * {@inheritDoc}
     */
    public function getHardSkills()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHardSkills', []);

        return parent::getHardSkills();
    }

    /**
     * {@inheritDoc}
     */
    public function setHardSkills($hardSkills)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHardSkills', [$hardSkills]);

        return parent::setHardSkills($hardSkills);
    }

    /**
     * {@inheritDoc}
     */
    public function getVacancy()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVacancy', []);

        return parent::getVacancy();
    }

    /**
     * {@inheritDoc}
     */
    public function setVacancy($vacancy)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVacancy', [$vacancy]);

        return parent::setVacancy($vacancy);
    }

    /**
     * {@inheritDoc}
     */
    public function getLastUpdateStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLastUpdateStatus', []);

        return parent::getLastUpdateStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setLastUpdateStatus($lastUpdateStatus)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLastUpdateStatus', [$lastUpdateStatus]);

        return parent::setLastUpdateStatus($lastUpdateStatus);
    }

    /**
     * {@inheritDoc}
     */
    public function getSkillsMap()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSkillsMap', []);

        return parent::getSkillsMap();
    }

    /**
     * {@inheritDoc}
     */
    public function setSkillsMap($skillsMap)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSkillsMap', [$skillsMap]);

        return parent::setSkillsMap($skillsMap);
    }

    /**
     * {@inheritDoc}
     */
    public function getSkillsWeight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSkillsWeight', []);

        return parent::getSkillsWeight();
    }

    /**
     * {@inheritDoc}
     */
    public function setSkillsWeight($skillsWeight)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSkillsWeight', [$skillsWeight]);

        return parent::setSkillsWeight($skillsWeight);
    }

    /**
     * {@inheritDoc}
     */
    public function getRho()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRho', []);

        return parent::getRho();
    }

    /**
     * {@inheritDoc}
     */
    public function setRho($rho)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRho', [$rho]);

        return parent::setRho($rho);
    }

    /**
     * {@inheritDoc}
     */
    public function getThreshold()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getThreshold', []);

        return parent::getThreshold();
    }

    /**
     * {@inheritDoc}
     */
    public function setThreshold($threshold)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setThreshold', [$threshold]);

        return parent::setThreshold($threshold);
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
    public function getCreatedAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreatedAt', []);

        return parent::getCreatedAt();
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
    public function getUpdatedAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdatedAt', []);

        return parent::getUpdatedAt();
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

}
