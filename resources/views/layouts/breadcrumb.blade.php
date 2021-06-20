<!-- BREADCRUMB-->
  <section class="au-breadcrumb m-t-75 ">
    @if (Session::has('status_import'))
            <div class="alert alert-success">
                {{Session::get('status_import')}}
            </div>
            {{Session::forget('status_import')}}
        @endif
      <div class="section__content section__content--p30 bg-white">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-md-12">
                      <div class="au-breadcrumb-content">
                          <div class="au-breadcrumb-left">
                              <h3 class="d-inline-block font-weight-light" style="color: #B3B3B3;">{{ $MainTitle }}</h3>
                              <h3 class="d-inline-block">&nbsp;>&nbsp;</h3>
                              <h3 class="d-inline-block">{{ $TitleName }}</h3>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!-- END BREADCRUMB-->