const mysql = require('promise-mysql')

export abstract class MySqlRepository {
  private static connection = null

  protected async getConnection() {
    if (MySqlRepository.connection === null) {
      const pool = await mysql.createPool({
        host: process.env.DEV_DB_HOST || process.env.DB_HOST,
        user: process.env.DEV_DB_USER || process.env.DB_USER,
        password: process.env.DEV_DB_PASSWORD || process.env.DB_PASSWORD,
        database: process.env.DEV_DB_DATABASE || process.env.DB_DATABASE
      })

      MySqlRepository.connection = pool.getConnection()
    }

    return MySqlRepository.connection
  }
}
