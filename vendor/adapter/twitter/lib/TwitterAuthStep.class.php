<?php

namespace Adapter\Twitter;

/**
 * Description of TwitterAuthStep.
 *
 * @author alberto
 */
class TwitterAuthStep
{
    protected $prefix = 'twitter.';
    protected $storage = null;

    public function __construct( $storage )
    {
        $this->storage = $storage;
        $this->storage->start();
    }

    /**
     * Returns if is the first call that user doing in page.
     *
     * @return boolean
     */
    public function isFirstCall()
    {
        return
        (
            !$this->storage->has( $this->prefix . 'oauth_token' )
            ||
            !$this->storage->has( $this->prefix . 'oauth_token_secret' )
        );
    }

    /**
     * Set if user need sign in Twitter.
     *
     * @param type $need boolean
     */
    public function setNeedSignin( $need )
    {
        $this->set( 'need_signin', $need );
    }

    /**
     * Return if user need sign in or not.
     *
     * @return boolean
     */
    public function getNeedSignin()
    {
        return $this->get( 'need_signin', false );
    }

    /**
     * Set a param with given key as given value.
     *
     * @param string $key Key to storage the value.
     * @param mixed $value Value to key.
     *
     * @return type
     */
    public function set( $key, $value )
    {
        if ( empty( $key ) )
        {
            throw new \RuntimeException( 'Required param not found.' );
        }

        return $this->storage->set( ( $this->prefix . $key ), $value );
    }

    /**
     * Search in storage system the given key and return if exists, false else.
     *
     * @param string $key Search for given key.
     * @param mixed $default_value If key dosn't exists return this default.
     *
     * @return mixed
     */
    public function get( $key, $default_value = null )
    {
        if ( empty( $key ) )
        {
            throw new \RuntimeException( 'Required param not found.' );
        }

        if ( $this->storage->has( $this->prefix . $key ) )
        {
            return $this->storage->get( $this->prefix . $key );
        }
        else if( !empty( $default_value ) )
        {
            return $default_value;
        }

        return false;
    }

    /**
     * Invalidate the session.
     */
    public function close()
    {
        $this->storage->invalidate();
    }

    /**
     * Delete all storage parameters and initialize it again.
     */
    public function regenerateStorage()
    {
        $this->close();
        $this->storage->start();
    }
}

?>
