var express = require('express');
var router = express.Router();
var modelFruit = require('./fruitsModel');

router.get('/list_fruits', async function (req, res, next) {
    try {
        var data = await modelFruit.find();
        res.json({ fruits: data });
    } catch (error) {
        console.error("Error occurred:", error);
        res.status(500).json({ error: 'Internal server error' });
    }
});

let tempData = {};
router.post('/receive_fruits', async function (req, res) {
    try {
        const { name, weight } = req.body;

        console.log("name", name);
        console.log("weight", weight);

        if (name !== undefined || weight !== undefined) {
            if (name !== undefined && weight === undefined) {
                tempData.name = name;
            }
            if (weight !== undefined && name === undefined) {
                tempData.weight = weight;
            }

            if (tempData.name !== undefined && tempData.weight !== undefined) {
                const existingFruit = await modelFruit.findOne({ name: tempData.name });

                if (existingFruit) {
                    existingFruit.weight += tempData.weight;
                    await existingFruit.save();
                    res.json({ status: 1, message: "Dữ liệu đã được cập nhật vào cơ sở dữ liệu thành công." });
                } else {
                    const fruit = new modelFruit({
                        name: tempData.name,
                        weight: tempData.weight
                    });
                    await fruit.save();
                    res.json({ status: 1, message: "Dữ liệu đã được lưu vào cơ sở dữ liệu thành công." });
                }

                tempData = {};
            } else {
                res.json({ status: 1, message: "Dữ liệu đã được nhận thành công. Đang chờ dữ liệu từ client khác." });
            }
        } else {
            res.status(400).json({ error: 'Bad Request - Thiếu thông tin về tên hoặc trọng lượng của trái cây.' });
        }
    } catch (error) {
        console.error("Error occurred:", error);
        res.status(500).json({ error: 'Internal server error' });
    }
});

// router.post('/receive_fruits', async function (req, res) {
//     try {
//         const { name, weight } = req.body;

//         console.log("name", name);
//         console.log("weight", weight);

//         if (name !== undefined || weight !== undefined) {
//             if (name !== undefined && weight === undefined) {
//                 tempData.name = name;
//             }
//             if (weight !== undefined && name === undefined) {
//                 tempData.weight = weight;
//             }

//             if (tempData.name !== undefined && tempData.weight !== undefined) {
//                 const fruit = new modelFruit({
//                     name: tempData.name,
//                     weight: tempData.weight
//                 });
//                 const result = await fruit.save();

//                 if (result) {
//                     res.json({ status: 1, message: "Dữ liệu đã được lưu vào cơ sở dữ liệu thành công." });
//                 } else {
//                     res.json({ status: 0, message: "Lưu dữ liệu vào cơ sở dữ liệu thất bại." });
//                 }

//                 tempData = {};
//             } else {
//                 res.json({ status: 1, message: "Dữ liệu đã được nhận thành công. Đang chờ dữ liệu từ client khác." });
//             }
//         } else {
//             res.status(400).json({ error: 'Bad Request - Thiếu thông tin về tên hoặc trọng lượng của trái cây.' });
//         }
//     } catch (error) {
//         console.error("Error occurred:", error);
//         res.status(500).json({ error: 'Internal server error' });
//     }
// });

router.post('/delete_fruits', async function (req, res) {
    try {
        const { value } = req.body;

        if (value && value === "oke") {
            await modelFruit.deleteMany({});
            res.json({ status: 1, message: "Dữ liệu đã được xóa khỏi cơ sở dữ liệu thành công." });
        } else {
            res.status(400).json({ error: 'Bad Request - Giá trị không hợp lệ hoặc thiếu.' });
        }
    } catch (error) {
        console.error("Error occurred:", error);
        res.status(500).json({ error: 'Internal server error' });
    }
});



module.exports = router;