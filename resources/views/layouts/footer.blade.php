<footer class="mt-24">

    <!-- MAIN FOOTER -->
    <div class="bg-gradient-to-br from-[#1E3A6D] via-[#1E3A6D] to-[#1E3A6D] text-white">
        <div class="max-w-7xl mx-auto px-6 py-20
                    grid grid-cols-1 md:grid-cols-4 gap-12">

            <!-- BRAND -->
            <div>
                <img
                    src="{{ asset('images/logo.jpg') }}"
                    alt="Job4U"
                    class="h-20 mb-6 bg-white p-2 rounded-xl"
                />

                <p class="text-sm leading-relaxed text-blue-100 max-w-sm">
                    JOB4U is the digital bridge between talented professionals
                    and organisations that value them.
                </p>

                <p class="mt-4 text-sm leading-relaxed text-blue-100">
                    Our platform supports fair recruitment, meaningful careers,
                    and sustainable workforce growth.
                </p>
            </div>

            <!-- PLATFORM -->
            <div>
                <h4 class="text-lg font-bold mb-5 tracking-wide">
                    Platform
                </h4>

                <ul class="space-y-3 text-sm text-blue-100">
                    <li>
                        <a href="{{ route('jobs.index') }}"
                           class="hover:text-[#55B84D] transition">
                            Browse Jobs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}"
                           class="hover:text-[#55B84D] transition">
                            Upload CV
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.edit') }}"
                           class="hover:text-[#55B84D] transition">
                            My Profile
                        </a>
                    </li>
                </ul>
            </div>

            <!-- EMPLOYERS -->
            <div>
                <h4 class="text-lg font-bold mb-5 tracking-wide">
                    Employers
                </h4>

                <ul class="space-y-3 text-sm text-blue-100">
                    <li>
                        <a href="{{ route('register') }}"
                           class="hover:text-[#55B84D] transition">
                            Post a Job
                        </a>
                    </li>
                    <li>
                        <a href="#"
                           class="hover:text-[#55B84D] transition">
                            Premium Listings
                        </a>
                    </li>
                </ul>
            </div>

            <!-- SUPPORT -->
            <div>
                <h4 class="text-lg font-bold mb-5 tracking-wide">
                    Support
                </h4>

                <ul class="space-y-3 text-sm text-blue-100">
                    <li>
                        <a href="#"
                           class="hover:text-[#55B84D] transition">
                            Privacy Policy
                        </a>
                    </li>
                    <li>
                        <a href="#"
                           class="hover:text-[#55B84D] transition">
                            Terms of Service
                        </a>
                    </li>
                    <li>
                        <a href="#"
                           class="hover:text-[#55B84D] transition">
                            Contact Us
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>

   <!-- BOTTOM BAR -->
    <div class="bg-[#55B84D]">
        <div class="max-w-7xl mx-auto px-6 py-5
                    flex items-center justify-center">

            <p class="text-sm font-semibold text-white text-center">
                © {{ date('Y') }} Job4U. All rights reserved.
            </p>

        </div>
    </div>


</footer>
