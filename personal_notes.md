PROJECT

1. combined frontend and backend to the same repository, didn't see a reason to separate them into different repositories for a test project

DATABASE

1. used "ip" as 39 chars long (looked up and found that it is the maximum ip address possible)

2. used "phone_number" as 30 chars, noticed in the dummy data, phone numbers where extremely long

3. kept all other VARCHAR fields as 255, felt like it should be enough for this project (in edge cases might need to think of a different solution)
