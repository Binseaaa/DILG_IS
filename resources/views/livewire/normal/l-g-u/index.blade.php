<div>
    <div class="container">
        <div class="row">
            <div class="col-md-6" style=" font-weight: 400; color:#3B6790;">
                <p style="font-weight: 500; font-size: 18px;">EXECUTIVE BRIEF</p>
                <p style="margin-top: 5px;">Location: 803 km. south of Manila 79 km southeast of Cebu</p>
                <p style="margin-top: -10px;">Capital : Tagbilaran City</p>
                <p style="margin-top: -10px;">Cities : 1</p>
                <p style="margin-top: -10px;">Municipalities : 47</p>
                <p style="margin-top: -10px;">Barangays : 1,113</p>
                <p style="margin-top: -10px;">Land Area : 4,117.26 square kilometers</p>
                <p style="margin-top: -10px;">Population : 1,313,560</p>
                <p style="margin-top: -10px;">Province: 1,230,110 (2007 Census)
                    City: 92,297 (2007 Census)</p>
                <p style="margin-top: -10px;">Language/Dialects : Boholano, English, Tagalog, Chinese</p>


            </div>
            <div class="col-md-6">
                <p class="text-justify" style="color:#727D73;">
                    THE Province of Bohol is an island haven tucked away in the Filipino region of Visayas.

                    This is one of the largest of more than 7,000 islands that comprise the Philippines, and it
                    consistently
                    draws tourists with its natural beauty, hilly interior and long stretches of white, sandy beaches.
                    Nested as it is in the midst of Visayas, Bohol has long been a protected center of culture and
                    politics.
                    Locals proudly refer to the island as the ‘Republic of Bohol’.

                    Vision: Bohol is a prime eco-cultural tourism destination and a strong, balanced agro-industrial
                    province, with a well educated, God-loving and law-abiding citizenry, proud of their cultural
                    heritage,
                    enjoying a state of well-being and committed to sound environment management.

                    Mission: To enrich Bohol’s social, economic, cultural, political and environmental resources through
                    good governance and effective partnerships with stakeholders for increase global competitiveness.
                    <br><br>
                    Goal: <br><br>

                    1. Environmental Protection and Management; <br>
                    2. Social Equity; <br>
                    3. Delivering quality services; <br>
                    4. Local/Regional Economic Development and Strategic Wealth Generation;<br>
                    5. Responsive, Transparent and Accountable Governance.
                </p>
            </div>
        </div>
    </div>

    <div class="container mb-4">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 mt-2">
                    <select class="form-select mt-1" wire:model="municipality">
                        <option value="all">All municipalities</option>
                        @foreach ($municipalities as $municipality)
                            <option value="{{ $municipality->id }}">{{ $municipality->municipality }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mt-2">
                    <input type="search" style="border-radius: 20px;" wire:model.delay.400ms="search"
                        class="form-control input" placeholder="Search">
                    <div wire:loading>
                        Searching...
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p class="text-center mt-3" style="color:dimgray; font-size: 22px; font-weight: 600;">LIST OF LOCAL ELECTIVE
        OFFICIALS
    </p>
    <div class="col-md-12">
        <div class="">
            <div class="row d-flex justify-content-center mb-3">
                @foreach ($lgus as $lgu)
                    <div class="col-md-3 card m-2 p-2 text-justify ">
                        <p class="text-center mb-3" style="font-weight: 600; font-size: 26px; color:#C9282D;">
                            {{ $lgu->municipality->municipality }}</p>

                        <p class="text-justify mt-2" style="color:dimgray; margin-top: -10px; font-size: 14px;"><span
                                style="font-weight: 700; color:dimgray ">Mayor: </span> {{ $lgu->mayor }}</p>
                        <p class="text-justify" style="color:dimgray; margin-top: -10px; font-size: 14px;"><span
                                style="font-weight: 700; color:dimgray">Vice Mayor: </span> {{ $lgu->vice_mayor }}</p>
                        <p class="mt-2 text-justify" style="color:dimgray; margin-top: -10px; font-size: 14px;"><span
                                style="font-weight: 700; color:dimgray">SB Member: </span> {{ $lgu->sb_member1 }}</p>
                        <p class="text-justify" style="color:dimgray; margin-top: -10px; font-size: 14px;"><span
                                style="font-weight: 700; color:dimgray">SB Member: </span> {{ $lgu->sb_member2 }}</p>
                        <p class="text-justify" style="color:dimgray; margin-top: -10px; font-size: 14px;"><span
                                style="font-weight: 700; color:dimgray">SB Member: </span> {{ $lgu->sb_member3 }}</p>
                        <p class="text-justify" style="color:dimgray; margin-top: -10px; font-size: 14px;"><span
                                style="font-weight: 700; color:dimgray">SB Member: </span> {{ $lgu->sb_member4 }}</p>
                        <p class="text-justify" style="color:dimgray; margin-top: -10px; font-size: 14px;"><span
                                style="font-weight: 700; color:dimgray">SB Member: </span> {{ $lgu->sb_member5 }}</p>
                        <p class="text-justify" style="color:dimgray; margin-top: -10px; font-size: 14px;"><span
                                style="font-weight: 700; color:dimgray">SB Member: </span> {{ $lgu->sb_member6 }}</p>
                        <p class="text-justify" style="color:dimgray; margin-top: -10px; font-size: 14px;"><span
                                style="font-weight: 700; color:dimgray">SB Member: </span> {{ $lgu->sb_member7 }}</p>
                        <p class="text-justify" style="color:dimgray; margin-top: -10px; font-size: 14px;"><span
                                style="font-weight: 700; color:dimgray">SB Member: </span> {{ $lgu->sb_member8 }}</p>

                        @if (($lgu->sb_member9 && $lgu->sb_member10) != null)
                            <p class="text-justify" style="color:dimgray; margin-top: -10px; font-size: 14px;"><span
                                    style="font-weight: 700; color:dimgray">SB Member: </span> {{ $lgu->sb_member9 }}
                            </p>
                            <p class="text-justify" style="color:dimgray; margin-top: -10px; font-size: 14px;"><span
                                    style="font-weight: 700; color:dimgray">SB Member: </span> {{ $lgu->sb_member10 }}
                            </p>
                        @endif

                        @if (($lgu->lb_pres && $lgu->psk_pres) != null)
                            <p class="text-justify" style="color:dimgray; margin-top: -10px; font-size: 14px;"><span
                                    style="font-weight: 700; color:dimgray">Liga ng mga Brgy. President: </span>
                                {{ $lgu->lb_pres }}</p>
                            <p class="text-justify" style="color:dimgray; margin-top: -10px; font-size: 14px;"><span
                                    style="font-weight: 700; color:dimgray">PSK President: </span> {{ $lgu->psk_pres }}
                            </p>
                        @endif
                        <br>

                        <p class="text-center" style="color:dimgray; margin-top: -10px; font-size: 15px;"><span
                                style="font-weight: 500; color:dimgray">No. of Barangays: </span>
                            {{ $lgu->municipality->num_of_brgys }}</p>

                        <div class="form-group " style="width: 170px;">
                            <select name="" id="" class="form-control">
                                @php $brgy = json_decode($lgu->municipality->barangays,true); @endphp
                                <option selected>List of Barangays ⥂ </option>
                                @foreach ((array) $brgy as $b)
                                    <li>
                                        <option value="">{{ $b }}</option>
                                    </li>
                                @endforeach
                            </select>
                        </div>
                        <div class="mx-auto col-md-12 mb-2">
                            <iframe class="text-center mx-auto" src="{{ $lgu->municipality->gmap_url }}" height="300"
                                width="100%"></iframe>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
