document.addEventListener('DOMContentLoaded', function() {
            const departmentHeaders = document.querySelectorAll('.department-header');

            departmentHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const departmentCard = this.closest('.department-card');
                    const departmentContent = departmentCard.querySelector('.department-content');

                    // Toggle the 'active' class on the department-card
                    departmentCard.classList.toggle('active');

                    // Set the max-height for smooth transition
                    if (departmentCard.classList.contains('active')) {
                        // When active, set max-height to scrollHeight to allow content to show
                        departmentContent.style.maxHeight = departmentContent.scrollHeight + 'px';
                    } else {
                        // When deactivating, set max-height back to 0
                        departmentContent.style.maxHeight = '0';
                    }

                    // Optional: Close other open accordions
                    departmentHeaders.forEach(otherHeader => {
                        const otherCard = otherHeader.closest('.department-card');
                        if (otherCard !== departmentCard && otherCard.classList.contains('active')) {
                            otherCard.classList.remove('active');
                            otherCard.querySelector('.department-content').style.maxHeight = '0';
                        }
                    });
                });
            });
        });
