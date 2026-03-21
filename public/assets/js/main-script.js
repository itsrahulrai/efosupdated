<script>
document.addEventListener("DOMContentLoaded", function () {

    const indiaStates = [
        { id: 1, name: "Andhra Pradesh" },
        { id: 2, name: "Arunachal Pradesh" },
        { id: 3, name: "Assam" },
        { id: 4, name: "Bihar" },
        { id: 5, name: "Chhattisgarh" },
        { id: 6, name: "Goa" },
        { id: 7, name: "Gujarat" },
        { id: 8, name: "Haryana" },
        { id: 9, name: "Himachal Pradesh" },
        { id: 10, name: "Jharkhand" },
        { id: 11, name: "Karnataka" },
        { id: 12, name: "Kerala" },
        { id: 13, name: "Madhya Pradesh" },
        { id: 14, name: "Maharashtra" },
        { id: 15, name: "Manipur" },
        { id: 16, name: "Meghalaya" },
        { id: 17, name: "Mizoram" },
        { id: 18, name: "Nagaland" },
        { id: 19, name: "Odisha" },
        { id: 20, name: "Punjab" },
        { id: 21, name: "Rajasthan" },
        { id: 22, name: "Sikkim" },
        { id: 23, name: "Tamil Nadu" },
        { id: 24, name: "Telangana" },
        { id: 25, name: "Tripura" },
        { id: 26, name: "Uttar Pradesh" },
        { id: 27, name: "Uttarakhand" },
        { id: 28, name: "West Bengal" },
        { id: 29, name: "Andaman and Nicobar Islands" },
        { id: 30, name: "Chandigarh" },
        { id: 31, name: "Dadra and Nagar Haveli and Daman and Diu" },
        { id: 32, name: "Delhi" },
        { id: 33, name: "Jammu and Kashmir" },
        { id: 34, name: "Ladakh" },
        { id: 35, name: "Lakshadweep" },
        { id: 36, name: "Puducherry" }
    ];

    const indiaDistricts = { /* your existing districts object */ };

    const stateDropdowns = document.querySelectorAll("[data-state]");

    /* ===== Populate States ===== */
    stateDropdowns.forEach(select => {
        indiaStates.forEach(state => {
            const option = document.createElement("option");

            option.value = state.name;       // ✅ STATE NAME AS VALUE
            option.textContent = state.name;
            option.dataset.id = state.id;    // ✅ KEEP ID FOR DISTRICTS

            select.appendChild(option);
        });
    });

    /* ===== Populate Districts ===== */
    stateDropdowns.forEach(stateSelect => {
        stateSelect.addEventListener("change", function () {

            const selectedOption = this.options[this.selectedIndex];
            const stateId = selectedOption.dataset.id; // ✅ ID FROM data-id

            const districtSelect = document.getElementById(this.dataset.target);
            districtSelect.innerHTML = `<option value="">Select District</option>`;

            if (indiaDistricts[stateId]) {
                indiaDistricts[stateId].forEach(district => {
                    const option = document.createElement("option");
                    option.value = district;
                    option.textContent = district;
                    districtSelect.appendChild(option);
                });
            }
        });
    });

});
</script>
