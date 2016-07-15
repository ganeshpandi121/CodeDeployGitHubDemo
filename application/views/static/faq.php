<script>
    $(document).ready(function () {
        $('.collapse').on('show.bs.collapse', function () {
            var id = $(this).attr('id');
            $('a[href="#' + id + '"]').closest('.panel-heading').addClass('active-faq');
            $('a[href="#' + id + '"] .panel-title span').html('<i class="glyphicon glyphicon-minus"></i>');
        });
        $('.collapse').on('hide.bs.collapse', function () {
            var id = $(this).attr('id');
            $('a[href="#' + id + '"]').closest('.panel-heading').removeClass('active-faq');
            $('a[href="#' + id + '"] .panel-title span').html('<i class="glyphicon glyphicon-plus"></i>');
        });
    });
</script>
<div class="container-fluid">
    <div class="container"> 
        <h2>Frequently Asked Questions (FAQ)</h2>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-group">
                    <div class="panel panel-default panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse"  href="#faq-cat-1-sub-1">
                                <h4 class="panel-title">
                                    Can I obtain pricing from vendors on smartcardmarket.com?
                                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                </h4>
                            </a>
                        </div>
                        <div id="faq-cat-1-sub-1" class="panel-collapse collapse">
                            <div class="panel-body">
                                Yes, you can receive multiple prices from a number of different vendors on SmartCardMarket.com you can then pit them against each other in a reverse auction for the best possible result for you!
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse"  href="#faq-cat-1-sub-2">
                                <h4 class="panel-title">
                                    What Can I purchase on smartcardmarket.com?
                                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                </h4>
                            </a>
                        </div>
                        <div id="faq-cat-1-sub-2" class="panel-collapse collapse">
                            <div class="panel-body">
                                Anything in the smart card industry! Not just all card types (gift cards, drivers licences, credit cards, SIM cards), PVC, chips, payment terminals, gift card programs, even card printers and lanyards!
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#faq-cat-1-sub-3">
                                <h4 class="panel-title">
                                    Can I have product manufactured through smartcardmarket.com?
                                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                </h4>
                            </a>
                        </div>
                        <div id="faq-cat-1-sub-3" class="panel-collapse collapse">
                            <div class="panel-body">
                                Yes! From quotation through to a completed product. You can even have it delivered to your door!
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse"  href="#faq-cat-1-sub-4">
                                <h4 class="panel-title">
                                    Can I manage my order from quote to delivery?
                                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                </h4>
                            </a>
                        </div>
                        <div id="faq-cat-1-sub-4" class="panel-collapse collapse">
                            <div class="panel-body">
                                Yes, through our online order management tool, you can communicate directly with the provider and freight forwarder. Receiving real time updates, and information direct to your device. Manage the process as much or as little as you like, you are always in control.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#faq-cat-1-sub-5">
                                <h4 class="panel-title">
                                    How can I get the best deal?
                                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                </h4>
                            </a>
                        </div>
                        <div id="faq-cat-1-sub-5" class="panel-collapse collapse">
                            <div class="panel-body">
                                Simply post your project and receive quotes from qualified suppliers. You can choose the best deal then and there or live chat with the provider for better terms. Or pit the providers against each other with our reverse auction functionality and watch what happens!
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse"  href="#faq-cat-1-sub-6">
                                <h4 class="panel-title">
                                    Is it free to use?
                                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                </h4>
                            </a>
                        </div>
                        <div id="faq-cat-1-sub-6" class="panel-collapse collapse">
                            <div class="panel-body">
                                If you are a buyer, yes!
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#faq-cat-1-sub-7">
                                <h4 class="panel-title">
                                    Can I pay in local currency?
                                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                </h4>
                            </a>
                        </div>
                        <div id="faq-cat-1-sub-7" class="panel-collapse collapse">
                            <div class="panel-body">
                                We accept USD amounts only.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#faq-cat-1-sub-8">
                                <h4 class="panel-title">
                                    Do I have protection as a buyer from unethical providers?
                                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                </h4>
                            </a>
                        </div>
                        <div id="faq-cat-1-sub-8" class="panel-collapse collapse">
                            <div class="panel-body">
                                Yes, this is twofold. 
                                <br>1: Our providers are required to pass comprehensive on-boarding criteria and most are best of breed for their region. 
                                <br>2: SmartCardMarket.com provide escrow services and the mechanism’s for progress payments should you require them. This ensures you are getting what you have paid for.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#faq-cat-1-sub-9">
                                <h4 class="panel-title">
                                    Can any supplier/manufacturer sell products on SmartCardMarket.com?
                                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                </h4>
                            </a>
                        </div>
                        <div id="faq-cat-1-sub-9" class="panel-collapse collapse">
                            <div class="panel-body">
                                No. We only work with the best. Ensuring excellent quality products, services and communication. Any provider who cannot maintain our specified service levels cannot maintain a position on SmartCardMarket.com
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#faq-cat-1-sub-10">
                                <h4 class="panel-title">
                                    How can I get the best price when buying products?
                                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                </h4>
                            </a>
                        </div>
                        <div id="faq-cat-1-sub-10" class="panel-collapse collapse">
                            <div class="panel-body">
                                Use our reverse auction functionality and see the results for yourself.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#faq-cat-1-sub-11">
                                <h4 class="panel-title">
                                    I don’t know local freight companies, how can I get my goods delivered to my door/desired delivery address? How do I know I am not being taken advantage of?
                                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                </h4>
                            </a>
                        </div>
                        <div id="faq-cat-1-sub-11" class="panel-collapse collapse">
                            <div class="panel-body">
                                Our Freight forwarders, like our providers, are some of the best in the business and cater to all requirements from courier to air and sea.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#faq-cat-1-sub-12">
                                <h4 class="panel-title">
                                    If the supplier/manufacturer requires a deposit up front, how can we be sure that our payment is protected.
                                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                </h4>
                            </a>
                        </div>
                        <div id="faq-cat-1-sub-12" class="panel-collapse collapse">
                            <div class="panel-body">
                                SmartCardMarket.com escrow service will securely hold your funds until the provider has provider has met your predetermined criteria, ensuring a risk free transaction.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#faq-cat-1-sub-13">
                                <h4 class="panel-title">
                                    What is Lead Time?
                                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                </h4>
                            </a>
                        </div>
                        <div id="faq-cat-1-sub-13" class="panel-collapse collapse">
                            <div class="panel-body">
                                The time the order is approved on SMARTCardMarket.com to the order being ready for dispatch from the sellers facility.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#faq-cat-1-sub-14">
                                <h4 class="panel-title">
                                    What is Auction Time?
                                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                </h4>
                            </a>
                        </div>
                        <div id="faq-cat-1-sub-14" class="panel-collapse collapse">
                            <div class="panel-body">
                               The Auction time is the time from posting of the project by the buyer, to when the project closes. Once a Project is posted, SMARTCardMarket.com counts down in a time frame request by the buyer. Sellers have this time to submit their bid and revise their bid according to their position in the auction. Once the countdown has finished, the auction is closed and no further bids are received. The buyer will then choose the successful bidder.
                            </div>
                        </div>
                    </div>
                     <div class="panel panel-default panel-faq">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#faq-cat-1-sub-15">
                                <h4 class="panel-title">
                                    Does the Price Quoted by the seller include delivery?
                                    <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                </h4>
                            </a>
                        </div>
                        <div id="faq-cat-1-sub-15" class="panel-collapse collapse">
                            <div class="panel-body">
                               No. All pricing quoted by sellers is Ex Works (Incoterms). Which means the buyer has the option to organise their own collection or have  SMARTCardMarket.com organise on their behalf. Ex Works terms, also allows a genuine apples for apples comparison for buyers for their respective sellers.
                            </div>
                        </div>
                    </div>
                </div>
            </div> 

        </div>
    </div>
</div>
