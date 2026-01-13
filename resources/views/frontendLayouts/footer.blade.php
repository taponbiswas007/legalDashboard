  <!-- Newsletter Start -->
  <div class="newsletter">
      <div class="container">
          <div class="section-header">
              <h2>Subscribe Our Newsletter</h2>
          </div>
          <div class="form-container">
              <div class="form">
                  <form action="{{ route('subscriber.store') }}" method="POST">
    @csrf
    <div class="gap-4 d-flex justify-content-between align-items-center">
        <div>
            <input type="email" name="subscriberemail" class="form-control" placeholder="Email here">
            @error('subscriberemail')
                <p class="text-red">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <button type="submit" class="btn">Submit</button>
    </div>
</form>

              </div>
          </div>
      </div>
  </div>
  <!-- Newsletter End -->
  <!-- Footer Start -->
  <div class="footer">
      <div class="container">
          <div class="row">

              <div class="col-12">
                  <div class="row g-4">
                      <div class="col-md-6 col-lg-4">
                          <div class="footer-link ">
                              <h2>High Court</h2>
                              <p>Supreme Court BAR Association Main Building</p>
                              <p>3rd Floor Room No - 412</p>

                              <p>Dhaka - 1100</p>
                              <a href="tel:01710884561">01710884561</a>
                              <a href="mailto:sksharifnassociates2002@gmail.com">sksharifnassociates2002@gmail.com</a>

                              <a href="mailto:2sksharifnassociates2002@gmail.com">2sksharifnassociates2002@gmail.com</a>
                          </div>
                      </div>
                      <div class="col-md-6 col-lg-4">
                          <div class="footer-link">
                              <h2>Judge court</h2>
                              <p>Haque Manshion, 41/42, Court House Street</p>
                              <p>Room no - 301, (2nd Floor)</p>
                              <p>West Side of C.M.M Court Hajat Khana Kotwali, Dhaka-1100.</p>
                              <a href="tel:01710884561">01710884561</a>
                              <a href="mailto:sksharifnassociates2002@gmail.com">sksharifnassociates2002@gmail.com</a>
                          </div>
                      </div>
                      <div class="col-md-6 col-lg-4">
                          <div class="footer-link">
                              <h2>Judge court</h2>
                              <p>23/1, Metropolitan Bar Association, (Ground Floor)</p>
                              <p>Room no- 3</p>
                              <p>Court House street, Dhaka-1100, Bangladesh</p>
                              <a href="tel:01710884561">01710884561</a>
                              <a href="mailto:sksharifnassociates2002@gmail.com">sksharifnassociates2002@gmail.com</a>
                              <!-- <p><i class="fa fa-map-marker-alt"></i>123 Street, New York, USA</p>
                            <p><i class="fa fa-phone-alt"></i>+012 345 67890</p>
                            <p><i class="fa fa-envelope"></i>info@example.com</p> -->

                          </div>
                      </div>
                      <div class="col-12">
                          <div class="footer-social">
                              <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                              <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
                              <a href="https://youtube.com" target="_blank"><i class="fab fa-youtube"></i></a>
                              <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
                              <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="container footer-menu">
          <div class="f-menu">
              <a href="">&copy; SK. Sharif & Associates, All Right Reserved.</a>
              <a href="https://www.bspdigitalsolutions.com">Designed by BSP Digital Solutions</a>
              <a href="">Terms of use</a>
              <a href="">Privacy policy</a>

          </div>
      </div>

  </div>
  <!-- Footer End -->
