@extends('layout.app', ['current_page' => 'payment'])

@section('body')
    <section class="pay mb100">
        <div class="container">
            <h1>{{__('web.how_to_pay')}}</h1>
            <div class="items">
                @foreach($payment_methods as $payment_method)
                    <div class="item">
                        <div class="part1">
                            @if($payment_method->relationLoaded('image') &&$payment_method->getRelation('image'))

                                {{ $payment_method->getRelation('image')?->img('', ['alt' => $payment_method->getAttribute('name'),'class'=>'img-responsive', 'onerror' => "this.src='" . asset('logo.svg') . "'"]) }}
                            @else
                                <img class="img-responsive" src="{{asset('logo.svg')}}" alt=""/>
                            @endif
                            <div class="infoPay">
                                <h2>{{$payment_method->name}}</h2>

                                @if(filled($payment_method->phone))
                                    <div class="phonenum">
                                        <h3>{{__('admin.phone')}}: </h3>
                                        <div class="allNumbers" style="margin-left: 5px; direction: ltr;">
                                            <p>
                                                {{$payment_method->phone}}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if(filled($payment_method->account_no))
                                    <div class="phonenum">
                                        <h3>{{__('admin.bank_account')}}: </h3>
                                        <div class="allNumbers">
                                            @foreach($payment_method->account_no as $account_no)
                                                <p>
                                                    {{$account_no['account_no']}}
                                                    <span> {{$account_no['currency']}}</span>
                                                </p>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                        @if(filled($payment_method->link)
                            )
                            <a href="{{$payment_method->link}}"
                               class="btn_page2">{{__('web.goto').' '.$payment_method->name}} </a>
                        @endif
                    </div>

                @endforeach

            </div>
        </div>
    </section>

@endsection
