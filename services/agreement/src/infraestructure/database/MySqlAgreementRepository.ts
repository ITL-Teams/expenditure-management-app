import { MySqlRepository } from './MySqlRepository'
import { IAgreementRepository } from '../../domain/IAgreementRepository'
import { AgreementId } from '../../domain/value-object/AgreementId'

export class MySqlAgreementRepository
  extends MySqlRepository
  implements IAgreementRepository {
  private readonly TABLE_NAME = 'agreement'


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
