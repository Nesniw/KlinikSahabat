@extends('layouts.master')

@section('content')

<section class="backgroundForm pt-5">
  <div class="container">
    <h2 class="mb-4 display-5 text-center text-danger">Hubungi Kami</h2>
    <div class="row justify-content-md-center my-5">
      <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-7 col-xxl-5">
        <iframe
            width="100%"
            height="300"
            style="border: 0;"
            loading="lazy"
            allowfullscreen
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.7013961273515!2d106.58956837498997!3d-6.170722393816609!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ff0efa31754b%3A0x8ea7307988726eb6!2sKLINIK%20SAHABAT%20HEWAN!5e0!3m2!1sid!2sid!4v1705002747394!5m2!1sid!2sid"
        ></iframe>
      </div>
      <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-5 col-xxl-5 my-auto ps-5">
        <p class="mb-2"><img src="/gambar/WA.png" alt="Custom Icon" class="icon me-2"><b>Nomor Whatsapp:</b></p>
        <p class="text-secondary mb-4 ms-1">0811-1345-710</p>
        <p class="mb-2"><img src="/gambar/Gmaps.png" alt="Custom Icon" class="icon me-2"><b>Alamat:</b></p>
        <p class="text-secondary ms-1">Jalan Raya Villa Tangerang Indah, Blok BE 01 No.14, RT.004/RW.12, 
          Gebang Raya, Kecamatan Periuk, Kota Tangerang, Banten 15132</p>
      </div>
    </div>
  </div>

  <div class="hr-theme-slash-2">
      <div class="hr-line"></div>
      <div class="hr-icon"><i class="material-icons">pets</i></div>
      <div class="hr-line"></div>
  </div>

  <div class="container mt-5">
    <h2 class="mb-3 text-center text-danger">Form Kontak</h2>
    <h6 class="mb-3 text-center text-secondary">Kirimkan kritik dan saran Anda melalui form kontak berikut</h6>
    <div class="row justify-content-lg-center">
      <div class="col-12 col-md-12 col-lg-10 col-xl-8">
        <div class="bg-white border rounded shadow-sm overflow-hidden">
          <form action="#!">
            <div class="row gy-4 gy-xl-4 p-4 p-xl-5">
              <div class="col-12">
                <label for="fullname" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="" required>
              </div>
              <div class="col-12 col-md-6">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                      <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                    </svg>
                  </span>
                  <input type="email" class="form-control" id="email" name="email" value="" required>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <label for="phone" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                      <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                    </svg>
                  </span>
                  <input type="tel" class="form-control" id="phone" name="phone" value="" required>
                </div>
              </div>
              <div class="col-12">
                <label for="message" class="form-label">Pesan <span class="text-danger">*</span></label>
                <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
              </div>
              <div class="col-12">
                <div class="d-grid">
                  <button class="btn btn-primary btn-lg" type="submit">Submit</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</section>

@endsection