<template>
  <div id="register" class="register-1 register-1-bg" style="padding-top: 6rem;">
    <div class="container" style="width: 55rem;">
      <div class="row">
        <div class="col-xl-12">
          <div class="image-container">
            <router-link class="navbar-brand logo-text" to="/">
              <img class="img-fluid" src="../../../images/Logo-black.png" alt="alternative" />
            </router-link>
          </div>
        </div>
        <h2 class="fw-bold">Payment</h2>
        <p class="text-light-blue">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas finibus erat quis
          metus tincidunt, vel faucibus tortor convallis. Duis nec vestibulum est, ac suscipit lacus.</p>
        <div class="container bg-white rounded-3">
          <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 px-md-auto p-4">
              <h2 class="fw-bold text-xl-start text-lg-start text-md-center">Payment</h2>
              <div class="text-xxl-start text-xl-start text-lg-start text-md-center text-sm-center">
                <h6 class="border-top-gray fw-semibold pt-3">Select Payment method</h6>
                <div class="form-check d-flex justify-content-xxl-start justify-content-lg-start justify-content-md-center justify-content-md-center align-items-center gap-2 mx-md-auto">
                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                  <label class="form-check-label" for="flexRadioDefault1">
                    <img class="img-fluid" src="../../../images/paypal.png" alt="paypal image" style="width: 4rem;" />
                  </label>
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-lg-6">
              <div class="card mx-auto" style="background: #ECF3FF; max-width: 350px">
                <div class="card-body p-2">
                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">Invoice</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Homeowner Association Registration fee</td>
                        <td class="fw-bold" style="text-align: end;"><h5>99.00</h5></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td class="fw-bold" style="text-align: end;"></td>
                      </tr>
                      <tr>
                        <td>VAT</td>
                        <td class="fw-bold" style="text-align: end;"><h5>12 %</h5></td>
                      </tr>
                      <tr>
                        <td>Discount</td>
                        <td class="fw-bold" style="text-align: end;"><h5>10.00</h5></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr class="border-top-gray">
                        <td><h3 class="fw-bold">Total</h3></td>
                        <td style="text-align: end; width: 10rem;"><h3 class="fw-bold">SR 100.88</h3></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="mx-auto">
                <button 
                 @click="pay()"
                  class="btn-solid-lg fw-bold mb-4 fs-5"
                  style="width: 22rem !important;" >Pay
                </button>
              </div>
             
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-xl-12 text-center mt-3">
          <p class="p-small text-light-blue">Naybiz © Copyright 2022, Inc. All rights reserved</p>
        </div>
      </div>
    </div>
  </footer>
</template>
<script>
  import { useUserStore } from '../../store/user';
  export default {
    methods: {
    },
    setup() {
      const userStore = useUserStore();
      return { userStore };
    },

    data() {
      return {
      };
    },
    methods: {
        pay()  {
        this.$swal.fire({
                        imageUrl: "https://naybiz.com/users/questions-icon.png",
                        title: "<h1 class='text-primary'>Registration</h1>",
                        text: 'Continue payment for HOA Subscription?',
                        color: 'black',
                        showDenyButton: true,
                        confirmButtonText: 'Confirm',
                        confirmButtonColor: '#0066ff'
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            await this.userStore.subscribeRegister(this.userStore['tmpUsername'], this.userStore['tmpEmail'], this.userStore['tmpPass'], this.userStore['subscriptionPlanId'], this.userStore['tmpUsername'])
                            if (this.userStore.response['status'] == false) {
                                if (this.userStore.response['errors']['email'] == 'The email has already been taken.') {
                                    this.$swal.fire({
                                        imageUrl: "https://naybiz.com/users/error-icon.png",
                                        title: "<h1 class='text-primary'>Login Failed</h1>",
                                        text: 'Email has already been used',
                                        color: 'black',
                                        confirmButtonText: 'Retry',
                                        confirmButtonColor: '#0066ff'
                                    })
                                }
                            }
                            else {
                              window.location.href = this.userStore.response['redirect_link']
                            }
                        }                     
                    })
      },
      async getPlans() {
        await this.userStore.subscriptionList()
        this.userStore.subscriptionPlanId = this.userStore.response[0]['id']        
      }
    },
    created() {
      this.getPlans();
    }
  }
</script>
<style scoped>
  .card {
    width: 100%;
    height: 70%;
    padding: 1rem !important;
    border: none;
    border-radius: 1rem;
    box-shadow: none;
  }

  .border-top-gray {
    border-top: 2px solid #DFDFDF;
  }
</style>