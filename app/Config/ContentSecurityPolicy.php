<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Stores the default settings for the ContentSecurityPolicy, if you
 * choose to use it. The values here will be read in and set as defaults
 * for the site. If needed, they can be overridden on a page-by-page basis.
 *
 * Suggested reference for explanations:
 *
 * @see https://www.html5rocks.com/en/tutorials/security/content-security-policy/
 */
class ContentSecurityPolicy extends BaseConfig
{
    // -------------------------------------------------------------------------
    // Broadbrush CSP management
    // -------------------------------------------------------------------------

    /**
     * Default CSP report context
     */
    public bool $reportOnly = false;

    /**
     * Specifies a URL where a browser will send reports
     * when a content security policy is violated.
     */
    public ?string $reportURI = null;

    /**
     * Instructs user agents to rewrite URL schemes, changing
     * HTTP to HTTPS. This directive is for websites with
     * large numbers of old URLs that need to be rewritten.
     */
    public bool $upgradeInsecureRequests = true;

    // -------------------------------------------------------------------------
    // Sources allowed
    // NOTE: once you set a policy to 'none', it cannot be further restricted
    // -------------------------------------------------------------------------

    /**
     * Will default to self if not overridden
     *
     * @var list<string>|string|null
     */
    public $defaultSrc = 'self';

    /**
     * Lists allowed scripts' URLs.
     * Inline <script> blocks must be tagged with <?= csp_script_nonce() ?>.
     *
     * @var list<string>|string
     */
    public $scriptSrc = [
        'self',
        'https://code.jquery.com',
        'https://ajax.googleapis.com',
        'https://cdn.jsdelivr.net',
        'https://cdnjs.cloudflare.com',
        'https://cdn.ckeditor.com',
        'https://www.googletagmanager.com',
        'https://www.google-analytics.com',
        'https://static.cloudflareinsights.com',
        'https://www.google.com',
        'https://www.gstatic.com',
        'https://challenges.cloudflare.com',
        'https://js.stripe.com',
        'https://www.paypal.com',
        'https://www.paypalobjects.com',
        'https://js.paystack.co',
        'https://checkout.razorpay.com',
        'https://checkout.flutterwave.com',
        'https://sdk.mercadopago.com',
        'https://app.sandbox.midtrans.com',
        'https://app.midtrans.com',
        'https://secure.payu.in',
        'https://secure.payu.com',
    ];

    /**
     * Lists allowed stylesheets' URLs.
     * 'unsafe-inline' is retained because Modesy uses many inline `style` attributes;
     * removing it would require a templating-level refactor.
     *
     * @var list<string>|string
     */
    public $styleSrc = [
        'self',
        "'unsafe-inline'",
        'https://fonts.googleapis.com',
        'https://cdn.jsdelivr.net',
        'https://cdnjs.cloudflare.com',
        'https://cdn.ckeditor.com',
    ];

    /**
     * Defines the origins from which images can be loaded.
     * https: is required because vendors/users can store external product/avatar URLs.
     *
     * @var list<string>|string
     */
    public $imageSrc = ['self', 'data:', 'blob:', 'https:'];

    /**
     * Restricts the URLs that can appear in a page's `<base>` element.
     * Mitigates DOM-clobbering / <base href> hijacking.
     *
     * @var list<string>|string|null
     */
    public $baseURI = 'self';

    /**
     * Lists the URLs for workers and embedded frame contents
     *
     * @var list<string>|string
     */
    public $childSrc = 'self';

    /**
     * Limits the origins that you can connect to (via XHR,
     * WebSockets, and EventSource).
     *
     * @var list<string>|string
     */
    public $connectSrc = [
        'self',
        'https://www.google-analytics.com',
        'https://api.stripe.com',
        'https://checkout.razorpay.com',
        'https://api.razorpay.com',
        'https://cdn.jsdelivr.net',
    ];

    /**
     * Specifies the origins that can serve web fonts.
     *
     * @var list<string>|string
     */
    public $fontSrc = [
        'self',
        'data:',
        'https://fonts.gstatic.com',
        'https://cdnjs.cloudflare.com',
        'https://cdn.jsdelivr.net',
    ];

    /**
     * Lists valid endpoints for submission from `<form>` tags.
     *
     * @var list<string>|string
     */
    public $formAction = [
        'self',
        'https://checkout.stripe.com',
        'https://www.paypal.com',
        'https://www.sandbox.paypal.com',
    ];

    /**
     * Specifies the sources that can embed the current page.
     * 'none' = no parent frame may embed us (clickjacking-proof).
     *
     * @var list<string>|string|null
     */
    public $frameAncestors = "'none'";

    /**
     * The frame-src directive restricts the URLs which may
     * be loaded into nested browsing contexts.
     *
     * @var list<string>|string|null
     */
    public $frameSrc = [
        'self',
        'https://js.stripe.com',
        'https://hooks.stripe.com',
        'https://checkout.stripe.com',
        'https://www.paypal.com',
        'https://www.sandbox.paypal.com',
        'https://www.google.com',
        'https://www.gstatic.com',
        'https://challenges.cloudflare.com',
        'https://checkout.razorpay.com',
        'https://api.razorpay.com',
        'https://www.youtube.com',
        'https://www.youtube-nocookie.com',
        'https://player.vimeo.com',
    ];

    /**
     * Restricts the origins allowed to deliver video and audio.
     *
     * @var list<string>|string|null
     */
    public $mediaSrc = ['self', 'data:', 'blob:', 'https:'];

    /**
     * Disable plugins (Flash, Java, etc.) — modern browsers ignore but VAPT scanners check.
     *
     * @var list<string>|string
     */
    public $objectSrc = "'none'";

    /**
     * @var list<string>|string|null
     */
    public $manifestSrc;

    /**
     * Limits the kinds of plugins a page may invoke.
     *
     * @var list<string>|string|null
     */
    public $pluginTypes;

    /**
     * List of actions allowed.
     *
     * @var list<string>|string|null
     */
    public $sandbox;

    /**
     * Nonce tag for style
     */
    public string $styleNonceTag = '{csp-style-nonce}';

    /**
     * Nonce tag for script
     */
    public string $scriptNonceTag = '{csp-script-nonce}';

    /**
     * Replace nonce tag automatically
     */
    public bool $autoNonce = true;
}
