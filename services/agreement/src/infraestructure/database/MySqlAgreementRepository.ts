import { MySqlRepository } from './MySqlRepository'
import { IAgreementRepository } from '../../domain/IAgreementRepository'
import { Agreement } from '../../domain/entity/Agreement'
import { AgreementId } from '../../domain/value-object/AgreementId'
import { AccountIdNotExists } from './error/AccountIdNotExist'

export class MySqlAgreementRepository
  extends MySqlRepository
  implements IAgreementRepository {
  private readonly TABLE_NAME = 'agreement'
  private readonly TABLE_NAME_USER = 'user_credentials'

  public async create(agreement: Agreement): Promise<void> {
    const connection = await this.getConnection()
    let error, results, field
    const sql = `INSERT INTO ${this.TABLE_NAME}
                    (
                        id,
                        account_id,
                        budget_id,
                        client_name,
                        agreement_message,
                        agreement_signature
                    ) SELECT ?,?,?,?,?,?
                    WHERE EXISTS ( SELECT id FROM ${this.TABLE_NAME_USER}
                        WHERE id = \'${agreement.getAccountId().toString()}\' )`

    // if (connection.affectedRows > 0)
    connection
      .query(
        sql,
        [
          agreement.getAgreementId().toString(),
          agreement.getAccountId().toString(),
          agreement.getBudgetId().toString(),
          agreement.getClientName().toString(),
          agreement.getAgreementMessage().toString(),
          agreement.getAgreementSignature().toString()
        ],
        function (err, result) {
          results = result
        }
      )
      .catch((err) => Promise.reject(err))
    if (results.affectedRows < 1) return connection
    throw new AccountIdNotExists(agreement.getAccountId().toString())
    // else
    //   throw new AccountIdNotExists(
    //     agreement.getAccountId().toString() + error + results + field
    //   )
  }

  public async delete(id: AgreementId): Promise<boolean> {
    const connection = await this.getConnection()
    const sql = `DELETE FROM ${this.TABLE_NAME} WHERE id = ?`

    const response = await connection
      .query(sql, [id.toString()])
      .catch((err) => Promise.reject(err))

    const userDeleted = response.affectedRows !== 0
    return userDeleted
  }
}
