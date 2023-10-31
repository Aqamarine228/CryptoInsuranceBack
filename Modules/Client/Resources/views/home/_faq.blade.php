<section class="faq-one">
    <div class="section-title text-center">
        <h2 class="section-title__title">{{__('home.faqTitle')}}</h2>
    </div>
    <div class="container">
        <div class="row">
            @foreach($faqs as $faq)
                <div class="col-xl-6 col-lg-6">
                    <div class="faq-one__single">
                        <div class="accrodion-grp faq-one-accrodion" data-grp-name="faq-one-accrodion-1">
                            <div class="accrodion">
                                <div class="accrodion-title">
                                    <h4><span>?</span> {{$faq->question}}</h4>
                                </div>
                                <div class="accrodion-content">
                                    <div class="inner">
                                        <p>{{$faq->answer}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
