# Buto-Plugin-GdprSign

<p>Plugin to handle GDPR approvals.</p>
<ul>
<li>Add folder /theme/[theme]/gdpr with file 1.0.pdf etc.</li>
<li>Add a widget on a page where user has signed in with role client to show approval button and link to GDPR document.</li>
<li>Check in session param plugin/gdpr/sign/user/new_version if any content should be hidden.</li>
<li>Data is stored in db.account_gdpr.</li>
<li>Show user list of approvals.</li>
</ul>

<a name="key_0"></a>

## Settings

<pre><code>plugin_modules:
  gdpr:
    plugin: gdpr/sign
plugin:
  gdpr:
    sign:
      enabled: true
      data:
        mysql: 'yml:/../buto_data/[theme]/mysql_[host].yml'
events:
  signin:
    -
      plugin: 'gdpr/sign'
      method: 'signin'</code></pre>

<a name="key_1"></a>

## Usage



<a name="key_2"></a>

## Pages



<a name="key_2_0"></a>

### page_approvals

<p>Page with list of approvals.</p>

<a name="key_2_1"></a>

### page_approvals_data

<p>Json data.</p>

<a name="key_2_2"></a>

### page_sign_capture

<p>Capture approval.</p>

<a name="key_3"></a>

## Widgets



<a name="key_3_0"></a>

### widget_sign

<p>Widget to show buttons for approval or view GDPR document.</p>
<pre><code>type: widget
data:
  plugin: 'gdpr/sign'
  method: sign</code></pre>

<a name="key_4"></a>

## Event



<a name="key_4_0"></a>

### event_signin

<p>Set data in session.</p>
<pre><code>plugin:
  gdpr:
    sign:
      user:
        version: '12.3'
        last_version: '12.3'
        new_version: false</code></pre>

<a name="key_5"></a>

## Construct



<a name="key_5_0"></a>

### __construct



<a name="key_6"></a>

## Methods



<a name="key_6_0"></a>

### db_open



<a name="key_6_1"></a>

### getSql



<a name="key_6_2"></a>

### db_account_gdpr_select_one



<a name="key_6_3"></a>

### db_account_gdpr_insert



<a name="key_6_4"></a>

### db_account_gdpr_select_many



<a name="key_6_5"></a>

### last_version

<p>Get last version in folder.</p>

