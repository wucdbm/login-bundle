# Login Bundle

A Symfony ~3.0 Bundle that eases logging users to your Symfony application.

Configuration Sample

```
wucdbm_login:
    managers:
        frontend:
            remember_me: true # If present, will always call remember me services and set a cookie
            firewall_name: frontend_area # Your firewall name
            hwi_oauth: # HWIOAuthBundle integration - for use directly with OAuth Access Tokens
                enabled: true
                token_class: Wucdbm\Bundle\LoginBundle\HWIOAuth\OAuthToken # You may change the token class to this
                # Or to your own class that extends the Bundle's token class. Using the above example 
                # In combination with the below setting will force the Token to return true to isAuthenticated calls
                # This resolves HWIOAuthBundle's issues with serialization and/or your users not having any roles by default
                # Which mostly leads to making HTTP requests to the OAuth APIs on E V E R Y page load.
                # PS You may also use that class, or your own implementation of this idea and a custom 
                # \HWI\Bundle\OAuthBundle\Security\Core\Authentication\Provider\OAuthProvider to prevent that
                # In the case of a normal web-redirect login flow with the bundle
                always_authenticated: true
                user_provider: app.auth.user_provider
```