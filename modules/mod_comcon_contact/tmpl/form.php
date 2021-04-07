<noscript>
  <h1 class="text__title">JavaScript must be enabled to use this form.</h1>
</noscript>
<form id="contactform"  class="contact-form form" autocomplete="off" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="title">Title</label>
    <select name="title" id="title">
      <option value="">Select an option</option>
      <option value="Mr">Mr</option>
      <option value="Mrs">Mrs</option>
      <option value="Ms">Ms</option>
      <option value="Other Title">Other</option>
    </select>
  </div>

  <div class="form-group">
    <label for="name" class="required">First name(s)</label>
    <input type="text" name="name" id="name" value="<?php echo isset($_GET["name"]) ? htmlspecialchars($_GET["name"]) : ""; ?>" required/>
  </div>

  <div class="form-group">
    <label for="surname" class="required">Last name</label>
    <input type="text" name="surname" id="surname" value="<?php echo isset($_GET["surname"]) ? htmlspecialchars($_GET["surname"]) : ""; ?>" required/>
  </div>

  <div class="form-group">
    <label for="type" class="required">Type of enquiry</label>
    <select name="type" id="type" value="<?php echo isset($_GET['type']) ? htmlspecialchars($_GET['type']) : ""; ?>" required>
      <option value="">Select an option</option>
      <option value="Architectural Enquiry">Architectural Enquiry</option>
      <option value="Building Trade Enquiry">Building Trade Enquiry</option>
      <option value="Private Enquiry">Private Enquiry</option>
      <option value="Acoustic Services Enquiry">Acoustic Services Enquiry</option>
    </select>
  </div>

  <div class="hr"></div>

  <h3 class="text__subsubheading">Company/Organisation Details</h3>

  <div class="form-group">
    <label for="org">Company/Organisation name</label>
    <input type="text" name="org" id="org" value="<?php echo isset($_GET['org']) ? htmlspecialchars($_GET['org']) : ""; ?>">
  </div>

  <div class="form-group">
    <label for="address1" class="required">Address Line 1</label>
    <input type="text" name="address1" id="address1" value="<?php echo isset($_GET['address1']) ? htmlspecialchars($_GET['address1']) : ""; ?>" required>
  </div>

  <div class="form-group">
    <label for="address2">Address Line 2</label>
    <input type="text" name="address2" id="address2" value="<?php echo isset($_GET['address2']) ? htmlspecialchars($_GET['address2']) : ""; ?>">
  </div>

  <div class="form-group">
    <label for="town" class="required">Town/City</label>
    <input type="text" name="town" id="town" value="<?php echo isset($_GET['town']) ? htmlspecialchars($_GET['town']) : ""; ?>" required>
  </div>

  <div class="form-group">
    <label for="county">County</label>
    <input type="text" name="county" id="county" value="<?php echo isset($_GET['county']) ? htmlspecialchars($_GET['county']) : ""; ?>">
  </div>

  <div class="form-group">
    <label for="postcode" class="required">Post Code</label>
    <input type="text" name="postcode" id="postcode" value="<?php echo isset($_GET['postcode']) ? htmlspecialchars($_GET['postcode']) : ""; ?>" required>
  </div>

  <div class="hr"></div>

  <h3 class="text__subsubheading">Contact Details</h3>

  <div class="form-group">
    <label for="tele" class="required">Contact Telephone number</label>
    <input type="tel" name="tele" id="tele" value="<?php echo isset($_GET['tele']) ? htmlspecialchars($_GET['tele']) : ""; ?>" required>
  </div>

  <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" name="email" id="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ""; ?>">
  </div>

  <div class="hr"></div>

  <h3 class="text__subsubheading">Project Details</h3>

  <div class="form-group">
    <label for="status" class="required">Project Status</label>
    <select name="status" id="status" value="<?php echo isset($_GET['status']) ? htmlspecialchars($_GET['status']) : ""; ?>" required>
      <option value="">Select an option</option>
      <option value="Fact Finding">Fact Finding</option>
      <option value="Tender">Tender</option>
      <option value="Live">Live</option>
    </select>
  </div>

  <div class="form-group">
    <label for="info" class="required">Project Information</label>
    <textarea name="info" id="info" cols="40" rows="5" placeholder="Please provide information about the nature of the project." required><?php echo isset($_GET['info']) ? htmlspecialchars($_GET['info']) : ""; ?></textarea>
  </div>

  <div class="form-group">
    <label for="products">Requested Products</label>
    <textarea name="products" id="products" cols="40" rows="5" placeholder="Please provide the name or type of products you need for the project."><?php echo isset($_GET['products']) ? htmlspecialchars($_GET['products']) : ""; ?></textarea>
  </div>

  <div class="form-group">
    <label for="comments">Further Comments</label>
    <textarea name="comments" id="comments" cols="40" rows="5" placeholder="Please provide any other relevant comments about the project."><?php echo isset($_GET['comments']) ? htmlspecialchars($_GET['comments']) : ""; ?></textarea>
  </div>

  <div class="form-group">
    <div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>" data-callback="recaptchaCallback" data-expired-callback="recaptchaExpired"></div>
    <!-- data-expired-callback="recaptchaExpired" -->
  </div>

  <div class="form-group">
    <input class="btn btn--inline" type="submit" name="send" id="send" value="Send">
  </div>
</form>
