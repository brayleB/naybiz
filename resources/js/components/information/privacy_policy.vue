<template>
  <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-dark" aria-label="Main navigation">
    <div class="container-xl container-lg container-fluid">
      <div class="image-container">
        <a class="navbar-brand logo-text d-lg-block d-sm-none logo-black" href="/">
          <img class="img-fluid" src="../../../images/Logo-white.png" alt="logo icon white" />
        </a>
        <a class="navbar-brand logo-text d-md-block d-lg-none p-1" href="/">
          <img class="img-fluid" src="../../../images/logo-icon.png" alt="logi icon" />
        </a>
      </div>


      <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="offcanvas-collapse"
        data-bs-target="#navbarsExampleDefault" id="navbarSideCollapse" aria-label="Toggle navigation"
        aria-controls="navbarsExampleDefault">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse offcanvas-collapse" tabindex="-1" id="navbarsExampleDefault" role="navigation">
        <ul class="navbar-nav ml-auto navbar-nav-scroll">
          <li class="nav-item d-md-inline-block d-lg-none">
            <a href="#header"><img class="img-fluid mt-3 ms-3" src="../../../images/Logo-white.png"
                alt="navbar brand logo" /></a>
          </li>
          <li class="nav-item">
            <a class="nav-link active px-3" aria-current="page" href="#header">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3" href="#about">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3" href="#benefits">Benefits</a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3" href="#pricing">Pricing</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto navbar-nav-scroll">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle ms-3" href="#" id="dropdown01" data-bs-toggle="dropdown"
              aria-expanded="false">{{ displayName }}</a>
            <ul class="dropdown-menu mx-3 mb-4" aria-labelledby="dropdown01">
              <li><a class="dropdown-item" href="#">Article Details</a></li>
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li><a class="dropdown-item" href="#">Terms Conditions</a></li>
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li><a class="dropdown-item" href="#">Privacy Policy</a></li>
            </ul>
          </li>
        </ul>
        <span class="nav-item">
          <router-link class="btn-solid-sm" style="margin-left: .8rem;" to="/register">Get
            Started</router-link>
        </span>
      </div>
    </div>
  </nav>

  <header id="register-1" class="register-1 register-1-bg">
    <div class="container" style="margin-top: 161px;">
      <div class="row">
        <div class="col-xl-12 d-flex justify-content-center">
          <div class="card text-start rounded-3 w-75">
            <div class="card-body p-5" style="overflow-y: scroll; max-height: 918px; border-bottom: 3px solid #67A2F9;">
              <h1 class="card-title fw-bold">PRIVACY POLICY</h1>
              <p class="card-text text-light-blue">Effective: December 14, 2022</p>
              <p class="card-text text-light-blue">By using the Naybiz, LLC website at naybiz.com (the “Site”) and its
                related sites, application, services and tools and/or registering for an account, operated by Naybiz,
                LLC (“The Naybiz Platform”), you expressly consent to our collection, use, disclosure, and retention of
                your personal information as described in this Privacy Policy and in our Terms and Conditions. </p>

              <p class="card-text text-light-blue">This Privacy Policy describes your privacy rights regarding our
                collection, use, storage, sharing, and
                protection of your personal information. It applies to the naybiz.com website, and all related sites,
                applications, services, and tools where this policy is referenced, regardless of how you access or use
                them. </p>

              <p class="card-text text-light-blue">We may amend this Privacy Policy at any time by posting the amended
                terms on this Site. All amended
                terms automatically take effect thirty (30) days after they are initially posted on the Site. We
                encourage you to periodically review this Privacy Policy to stay informed. Your continued use of any
                sites, including naybiz.com after new or amended terms are effective will constitute acknowledgment and
                acceptance of such new or amended terms.
              </p>

              <h5 class="card-subtitle text-light-blue mt-5 mb-3">Types of Information We Collect</h5>
              <p class="card-text text-light-blue">You can browse our website without telling us who you are or
                revealing any personal information about yourself. If you choose to provide us with personal
                information, you consent to the transfer and storage of that information on our servers.
              </p>
              <ol class="list-group list-group-numbered text-light-blue">
                <li class="list-group-item fw-semibold" style="color: #768BB1;">
                  <span class="p-large fw-semibold text-light-blue">Information You Provide: </span>
                  <p class="card-text text-light-blue">If you register for an account with us, you give us your personal
                    information. Any information you provide to us via our website or any other method will be collected
                    and stored. In order to provide you with the use of and access to our website, applications,
                    services and tools, information collected may include:</p>
                  <ul class="list-inline-item fw-normal">
                    <li class="fw-normal">email address, telephone number, mobile telephone number, physical contact
                      information, and sometimes financial information, such as credit card or bank account numbers;
                    </li>
                    <li class="fw-normal">transactional information based on your activities on the sites;</li>
                    <li class="fw-normal">personal information you provide to us through discussions, member information
                      pages, correspondence, dispute resolution, or shared by you from other applications, services, or
                      websites; and </li>
                    <li class="fw-normal">additional personal information we may request in order to authenticate you or
                      if we believe you are violating our policies. </li>
                  </ul>
                </li>
                <li class="list-group-item fw-semibold" style="color: #768BB1;">
                  <span class="p-large fw-semibold text-light-blue">Automatic Information and Other Sources: </span>
                  <p class="card-text text-light-blue">When you visit our website or use our applications, services, or
                    tools, we collect information sent to us by your computer, mobile phone, or other access device.
                    This information is not associated with you personally unless you sign-in as a registered user and
                    may include, but is not limited to, unique device identifier, device type, your location, computer
                    and connection information, IP address and standard web log information.</p>
                </li>
              </ol>

              <h5 class="card-subtitle text-light-blue mt-5 mb-3">How We Use Your Information</h5>
              <p class="card-text text-light-blue">Our primary reason for collecting personal information about you is
                to enable us to provide you with access to our sites and our services, and provide you with a safe,
                smooth, efficient, and customized experience. You agree that any information we collect from you may be
                used in any of the following ways: </p>
              <ol class="list-group list-group-unstyled">
                <li class="list-group-item fw-semibold" style="color: #768BB1;">
                  <ul class="list-inline-item fw-normal">
                    <li class="fw-normal">To provide access to the sites, services and customer support you request and
                      personalize your experience;</li>
                    <li class="fw-normal">To improve our website and our customer service; </li>
                    <li class="fw-normal">To prevent, detect, and investigate potentially prohibited or illegal
                      activities, and enforce our User Agreement; </li>
                    <li class="fw-normal">To process transactions; </li>
                    <li class="fw-normal">To tell you about our services and those of our affiliates, deliver targeted
                      marketing, service updates, and promotional offers based on your communication preferences; </li>
                    <li class="fw-normal">To resolve disputes, collect fees, and troubleshoot problems; </li>
                    <li class="fw-normal">To compare information for accuracy, and verify it with third parties;</li>
                    <li class="fw-normal">To contact you at telephone numbers we have collected, by placing a voice call
                      or through text (SMS) or email messaging;</li>
                    <li class="fw-normal">To provide other services requested by you;</li>
                  </ul>
                </li>
              </ol>

              <h5 class="card-subtitle text-light-blue mt-5 mb-3">How We Share Information </h5>
              <p class="card-text text-light-blue">We do not sell or rent your personal information to third parties for
                their marketing purposes without your express consent. We share your personal information as described
                below:
              </p>
              <ol class="list-group list-group-numbered text-light-blue">
                <li class="list-group-item fw-semibold" style="color: #768BB1;">
                  <span class="p-large fw-semibold text-light-blue">Third-Party Service Providers </span>
                  <p class="card-text text-light-blue">We share your personal information with trusted third parties and
                    service providers who assist us in operating our business and they have access to your personal
                    information needed to perform their functions. They may not use your personal information for any
                    other purpose. </p>
                </li>
                <li class="list-group-item fw-semibold" style="color: #768BB1;">
                  <span class="p-large fw-semibold text-light-blue">Promotional Offers and Improvement </span>
                  <p class="card-text text-light-bl ue">We may combine your personal information with information we
                    collect from other companies and use it to improve and personalize our sites, services, content and
                    advertising. </p>
                </li>
                <li class="list-group-item fw-semibold" style="color: #768BB1;">
                  <span class="p-large fw-semibold text-light-blue">Required by Law </span>
                  <p class="card-text text-light-blue">We disclose personal information to respond to legal
                    requirements, enforce our policies, respond to claims that a listing or other content violates the
                    rights of others, or protect anyone’s rights, property, or safety. Such information will be
                    disclosed in accordance with applicable laws and regulations. </p>
                </li>
                <li class="list-group-item fw-semibold" style="color: #768BB1;">
                  <span class="p-large fw-semibold text-light-blue">Business Transfers </span>
                  <p class="card-text text-light-blue">In the event of a sale or transfer of substantially all of
                    Naybiz, LLC’s assets, customer information may be one of the transferred assets.</p>
                </li>
              </ol>

              <h5 class="card-subtitle text-light-blue mt-5 mb-3">What About Third Parties </h5>
              <p class="card-text text-light-blue">We may, in our discretion, include or offer third party products or
                services on our website. The Naybiz Platform does not control the privacy policies of third parties, and
                you are subject to the privacy policies of those third parties where applicable.
              </p>

              <h5 class="card-subtitle text-light-blue mt-5 mb-3">Are Children Allowed </h5>
              <p class="card-text text-light-blue">Our sites and services are not directed to children under the age of
                13. Consistent with the Children’s Online Privacy Protection Act of 1998 (COPPA), we will never
                knowingly request personal information from anyone under the age of 13 without parental consent. By
                providing information to The Naybiz Platform you represent that you are 13 years of age or older. </p>

              <h5 class="card-subtitle text-light-blue mt-5 mb-3">How Information You Share May be Accessed </h5>
              <p class="card-text text-light-blue">If you are a registered user of our sites or services, information
                you publish or otherwise post for public viewing will be displayed and is available to the public. Also,
                if you access our sites from a shared computer, certain information about you, such as your account
                information or activity may also be visible to other individuals who use the computer after you.
              </p>

              <h5 class="card-subtitle text-light-blue mt-5 mb-3">How Do We Protect Your Information </h5>
              <p class="card-text text-light-blue">While we cannot guarantee the privacy or security of your
                information, we have implemented reasonable security measures to maintain the safety of your personal
                information and reduce the risks of loss, misuse, unauthorized access, disclosure and alteration.
              </p>

              <h5 class="card-subtitle text-light-blue mt-5 mb-3">Cookies </h5>
              <p class="card-text text-light-blue">We use “cookies” (small data files placed within your computing
                device) on certain of our pages to help recognize your device, provide personalized content, and
                customize our services, content and advertising. Most cookies are “session cookies,” meaning that they
                are automatically deleted from your hard drive at the end of a session. You are always free to decline
                our cookies if your browser permits, although doing so may interfere with your use of some of our sites
                or services.
              </p>

              <h5 class="card-subtitle text-light-blue mt-5 mb-3">Log Files </h5>
              <p class="card-text text-light-blue">We, like most sites, automatically gather information regarding your
                interaction with the Site and store it in log files. This data includes Internet Protocol (“IP”)
                addresses, browser type, Internet Service Provider (“ISP”), entry and exit pages, date, and time. We use
                this data to analyze trends, administer the Site, track users’ movements, and gather demographic
                information about our user base overall. Generally, we do not link this automatically collected
                information to personally identifiable information.
              </p>

              <h5 class="card-subtitle text-light-blue mt-5 mb-3">How You Can Access, Review and Change Your Personal
                Information </h5>
              <p class="card-text text-light-blue">You can see, review, and change most of your personal information by
                accessing your account profile settings. We retain information as long as it is necessary and relevant
                for our operations. In addition, please be advised that we may retain personal information from closed
                accounts to comply with law, prevent fraud, collect any fees owed, resolve disputes, troubleshoot
                problems, assist with any investigations, and take other actions otherwise permitted by law. </p>
            </div>
            <div class="container d-flex justify-content-between mt-5" style="width: 30rem;">
              <router-link class="button-991 btn-solid-lg float-md-start fw-bold px-5" style="width: 12rem;"
                to="/accept">Accept</router-link>
              <router-link class="text-primary float-md-start text-decoration-none mx-4 mt-3 fw-bold px-5"
                style="width: 12rem;" to="/decline">Decline</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <footer class="text-center text-lg-start text-white" style="background-color: #1760E8;">
    <div class="container p-4">
      <div class="row my-4">
        <div
          class="col-lg-4 col-md-12 mb-4 d-flex align-items-center justify-content-lg-between justify-content-md-center">
          <a href="/"><img class="img-fluid" src="../../../images/Logo-white.png" alt="footer brand logo" />
          </a>
        </div>
        <div class="col-lg-4 col-md-6 mt-1 text-md-start text-sm-start">
          <h5 class="mb-4 text-white">Help and Information</h5>
          <ul class="list-unstyled">
            <li class="mb-2">
              <a href="#!" class="text-white text-decoration-none">About Us</a>
            </li>
            <li class="mb-2">
              <a href="#!" class="text-white text-decoration-none">Frequently Asked Questions (FAQs)</a>
            </li>
            <li class="mb-2">
              <router-link class="text-white text-decoration-none" to="/terms_and_conditions">Terms and
                Conditionss</router-link>
            </li>
            <li class="mb-2">
              <router-link class="text-white text-decoration-none" to="/privacy_policy">Privacy Policy</router-link>
            </li>
            <li class="mb-2">
              <a href="#!" class="text-white text-decoration-none">Blogs</a>
            </li>
          </ul>
        </div>
        <div class="col-lg-4 col-md-6 mt-1 text-md-start text-sm-start">
          <h5 class="mb-4 text-white">Contact Us</h5>
          <span class="text-white span-991">For any additional questions, feel free to contact us here</span>
          <form>
            <div class="input-group">
              <input type="email" class="bottom-border w-75 bottom-container" placeholder="Enter your email"
                aria-label="Enter your email" aria-describedby="email" required />
              <span class="input-group-text bottom-border w-25 d-flex justify-content-end" id="basic-addon2">
                <i class="fas fa-envelope" aria-hidden="true"></i></span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </footer>
    <div class="container" aria-label="copyright">
      <div class="row">
        <div class="col-xl-12 text-center mt-3">
          <p class="p-small text-light-blue">Naybiz © Copyright 2022, Inc. All rights reserved</p>
        </div>
      </div>
    </div>
</template>

<script>
</script>

<style scoped>
  /* width */
  ::-webkit-scrollbar {
    width: 7px;
  }

  /* Track */
  ::-webkit-scrollbar-track {
    box-shadow: inset 0 0 5px grey;
    /* border-radius: .3rem; */
    margin-bottom: 1rem;
  }

  /* Handle */
  ::-webkit-scrollbar-thumb {
    background: #67A2F9;
  }

  /* Handle on hover */
  ::-webkit-scrollbar-thumb:hover {
    background: #67A2F9;
  }

  .s {
    list-style-type: disc;
    color: red;
  }
</style>