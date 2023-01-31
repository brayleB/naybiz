<template>
  <div id="register" class="register-1 register-1-bg" style="padding-top: 6rem;">
    <div class="container" style="width: 75rem;">
          <div class="row px-3 d-flex align-items-center justify-content-between g-5">
            <div class="col-xl-5 col-lg-5 col-md-7 mx-lg-1 mx-md-auto">
              <h2 class="fw-bold text-xl-start text-lg-start text-md-center">Complete your payment</h2>
              <p class="text-xl-start text-lg-start text-md-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas finibus erat quis
                metus tincidunt,
                vel faucibus tortor convallis. Duis nec vestibulum est, ac suscipit lacus.</p>
              <div class="row">
                <div class="col-xl-10">
                  <div class="card mx-auto mt-0">
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
                            <td >Homeowner Association Registration fee</td>
                            <td class="fw-bold" style="text-align: end;"><h5>99.00</h5></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td class="fw-bold" style="text-align: end;"></td>
                          </tr>
                          <tr>
                            <td><h5></h5>VAT</td>
                            <td class="fw-bold" style="text-align: end;"><h5>12 %</h5></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
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
                </div>
              </div>
            </div>
            <div class="payment-form col-xl-6 col-lg-6 col-md-9 mx-md-auto col-sm-12 border border-2 rounded-4 border-white" style="background: #d7e5fa;" >
              <form @submit.prevent="login" class="p-5">
                <div class="form-group">
                  <h2 class="fw-bold text-xl-start">Login Paypal Account</h2>
                </div>
                <div class="form-group">
                  <input type="email" v-model="email" class="form-control-input" placeholder="Enter email address"
                    required />
                </div>
                <div class="form-group">
                  <div class="field has-addons">
                    <div class="control is-expanded position-relative">
                      <input v-if="showPassword" type="text" class="form-control-input" v-model="password"
                        placeholder="Enter password" required />
                      <input v-else type="password" class="form-control-input" v-model="password"
                        placeholder="Enter password" />
                    </div>
                    <div class="control position-absolute" style="top: 17%; right: 2%;">
                      <button class="btn eye-border" type="button" @click.prevent="toggleShowPassword">
                        <span class="icon is-small is-right">
                          <i class="fas text-primary"
                            :class="{ 'fa-eye-slash': showPassword, 'fa-eye': !showPassword }"></i>
                        </span>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <button type="submit" class="form-control-submit-button fs-6 fw-bold mb-4">Pay</button>
                  <router-link class="text-black text-decoration-none fw-bold" style="margin-top: 1rem;"
                    to="/hoa/payment">Back</router-link>
                </div>
              </form>
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
    computed: {
      buttonLabel() {
        return (this.showPassword) ? "Hide" : "Show";
      }
    },
    methods: {
      toggleShowPassword() {
        this.showPassword = !this.showPassword;
      },
    },
    setup() {
      const userStore = useUserStore();
      return { userStore };
    },

    data() {
      return {
        showPassword: false
      };
    },
  }
</script>
<style scoped>
  .card {
    width: 100%;
    height: 87%;
    padding: 1rem !important;
    border: none;
    border-radius: 1rem;
    box-shadow: none;
  }

  .border-top-gray {
    border-top: 2px solid #DFDFDF;
  }
  
  input {
    font-size: 20px;
  }

  input::placeholder {
    color: #768BB1;
    font-weight: 400;
  }
</style>