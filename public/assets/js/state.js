
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
        { id: 36, name: "Puducherry" },
        { id: 37, name: "Pan India" },
         { id: 38, name: "Others" },
    ];

   const indiaDistricts = {

    // Andhra Pradesh
    1: ["Anantapur", "Chittoor", "East Godavari", "Guntur", "Kadapa", "Krishna", "Kurnool", "Nellore", "Prakasam", "Srikakulam", "Visakhapatnam", "Vizianagaram", "West Godavari"],

    // Arunachal Pradesh
    2: ["Itanagar", "Tawang", "Ziro", "Pasighat", "Bomdila"],

    // Assam
    3: ["Guwahati", "Dibrugarh", "Jorhat", "Silchar", "Tezpur", "Nagaon"],

    // Bihar
    4: ["Patna", "Gaya", "Muzaffarpur", "Darbhanga", "Bhagalpur", "Purnia", "Ara", "Begusarai"],

    // Chhattisgarh
    5: ["Raipur", "Bilaspur", "Durg", "Bhilai", "Korba", "Jagdalpur"],

    // Goa
    6: ["North Goa", "South Goa"],

    // Gujarat
    7: ["Ahmedabad", "Surat", "Vadodara", "Rajkot", "Bhavnagar", "Junagadh", "Jamnagar"],

    // Haryana
    8: ["Gurugram", "Faridabad", "Panipat", "Sonipat", "Rohtak", "Hisar", "Karnal"],

    // Himachal Pradesh
    9: ["Shimla", "Kangra", "Mandi", "Solan", "Una", "Hamirpur"],

    // Jharkhand
    10: ["Ranchi", "Jamshedpur", "Dhanbad", "Bokaro", "Hazaribagh"],

    // Karnataka
    11: ["Bengaluru", "Mysuru", "Mangaluru", "Hubli", "Belagavi", "Ballari", "Tumakuru"],

    // Kerala
    12: ["Thiruvananthapuram", "Kochi", "Kozhikode", "Thrissur", "Kannur", "Alappuzha"],

    // Madhya Pradesh
    13: ["Bhopal", "Indore", "Gwalior", "Jabalpur", "Ujjain", "Sagar"],

    // Maharashtra
    14: ["Mumbai", "Pune", "Nagpur", "Nashik", "Aurangabad", "Solapur", "Kolhapur"],

    // Manipur
    15: ["Imphal East", "Imphal West", "Churachandpur"],

    // Meghalaya
    16: ["Shillong", "Tura", "Jowai"],

    // Mizoram
    17: ["Aizawl", "Lunglei", "Champhai"],

    // Nagaland
    18: ["Kohima", "Dimapur", "Mokokchung"],

    // Odisha
    19: ["Bhubaneswar", "Cuttack", "Rourkela", "Sambalpur", "Balasore"],

    // Punjab
    20: ["Ludhiana", "Amritsar", "Jalandhar", "Patiala", "Bathinda"],

    // Rajasthan
    21: ["Jaipur", "Jodhpur", "Udaipur", "Ajmer", "Bikaner", "Kota"],

    // Sikkim
    22: ["Gangtok", "Namchi", "Gyalshing"],

    // Tamil Nadu
    23: ["Chennai", "Coimbatore", "Madurai", "Salem", "Trichy", "Tirunelveli"],

    // Telangana
    24: ["Hyderabad", "Warangal", "Nizamabad", "Karimnagar", "Khammam"],

    // Tripura
    25: ["Agartala", "Udaipur", "Dharmanagar"],

    // Uttar Pradesh
    26: ["Lucknow", "Noida", "Ghaziabad", "Kanpur", "Varanasi", "Prayagraj", "Agra", "Meerut"],

    // Uttarakhand
    27: ["Dehradun", "Haridwar", "Roorkee", "Haldwani", "Nainital"],

    // West Bengal
    28: ["Kolkata", "Howrah", "Durgapur", "Asansol", "Siliguri"],

    // Andaman & Nicobar
    29: ["Port Blair"],

    // Chandigarh
    30: ["Chandigarh"],

    // Dadra & Nagar Haveli and Daman & Diu
    31: ["Daman", "Diu", "Silvassa"],

    // Delhi
    32: ["New Delhi", "North Delhi", "South Delhi", "East Delhi", "West Delhi"],

    // Jammu & Kashmir
    33: ["Srinagar", "Jammu", "Anantnag", "Baramulla"],

    // Ladakh
    34: ["Leh", "Kargil"],

    // Lakshadweep
    35: ["Kavaratti"],

    // Puducherry
    36: ["Puducherry", "Karaikal", "Mahe", "Yanam"],

    37: ["Pan India"],
    
     38: ["Others"]
};
    

    const stateDropdowns = document.querySelectorAll("[data-state]");

    /* ===== Populate States ===== */
    stateDropdowns.forEach(select => {
        indiaStates.forEach(state => {
            const option = document.createElement("option");

            option.value = state.name;       //  STATE NAME AS VALUE
            option.textContent = state.name;
            option.dataset.id = state.id;    //  KEEP ID FOR DISTRICTS

            select.appendChild(option);
        });
    });

    /* ===== Populate Districts ===== */
    stateDropdowns.forEach(stateSelect => {
        stateSelect.addEventListener("change", function () {

            const selectedOption = this.options[this.selectedIndex];
            const stateId = selectedOption.dataset.id; // ID FROM data-id

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
