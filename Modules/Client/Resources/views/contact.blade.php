@extends('client::layouts.master')

@section('content')
    <section class="page-header">
        <div class="page-header-bg"
             style="background-image: url({{Module::asset('client:images/backgrounds/page-header-bg.jpg')}})">
        </div>
        <div class="page-header-shape-1"><img src="{{Module::asset('client:images/shapes/page-header-shape-1.png')}}"
                                              alt=""></div>
        <div class="container">
            <div class="page-header__inner">
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{route('client.home')}}">{{__('pages.home')}}</a></li>
                    <li><span>/</span></li>
                    <li>{{__('pages.contact')}}</li>
                </ul>
                <h2>{{__('pages.contact')}}</h2>
            </div>
        </div>
    </section>
    <section class="contact-page">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5">
                    <div class="contact-page__left">
                        <div class="section-title text-left">
                            <div class="section-sub-title-box">
                                <p class="section-sub-title">{{__('contact.contactUs')}}</p>
                                <div class="section-title-shape-1">
                                    <img src="{{Module::asset('client:images/shapes/section-title-shape-1.png')}}"
                                         alt="">
                                </div>
                                <div class="section-title-shape-2">
                                    <img src="{{Module::asset('client:images/shapes/section-title-shape-2.png')}}"
                                         alt="">
                                </div>
                            </div>
                            <h2 class="section-title__title">{{__('contact.title')}}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7">
                    <div class="contact-page__right">
                        <div class="contact-page__form">
                            <form action="{{route('client.contact')}}"
                                  class="comment-one__form contact-form-validated"
                                  method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="comment-form__input-box">
                                            <input type="text" placeholder="{{__('contact.form.name')}}" name="name">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="comment-form__input-box">
                                            <input type="email" placeholder="{{__('contact.form.email')}}" name="email">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="comment-form__input-box">
                                            <input type="text" placeholder="{{__('contact.form.phone')}}" name="phone">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="comment-form__input-box">
                                            <input type="text" placeholder="{{__('contact.form.subject')}}"
                                                   name="subject">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="comment-form__input-box text-message-box">
                                            <textarea name="text"
                                                      placeholder="{{__('contact.form.message')}}"></textarea>
                                        </div>
                                        <div class="comment-form__btn-box">
                                            <button type="submit"
                                                    class="thm-btn comment-form__btn mt-5">{{__('contact.form.submit')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
